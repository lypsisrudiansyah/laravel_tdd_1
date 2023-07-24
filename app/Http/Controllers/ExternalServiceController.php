<?php

namespace App\Http\Controllers;

use App\Models\ExternalService;
use Google\Client;
use Illuminate\Http\Request;
use App\CustomServices\GoogleOAuthApiClient;
use App\Models\Task;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use ZipArchive;

class ExternalServiceController extends Controller
{
    public function connectService($serviceName, GoogleOAuthApiClient $client)
    {
        if ($serviceName === 'google-drive') {
            // * when still using helpers function to shortern handling google oauth api client - but now we handling it on singleton instance
            // $client = self::customGoogleApiClientHandler();

            $client->setScopes(self::GDRIVE_SCOPES);
            $url = $client->createAuthUrl();

            // return $url;
            return response()->json([
                'auth_url' => $url
            ])->setStatusCode(200);
        }
    }

    public function callback(Request $request, GoogleOAuthApiClient $client)
    {
        // * when still using helpers function to shortern handling google oauth api client - but now we handling it on singleton instance
        // $client = self::customGoogleApiClientHandler();

        Log::info('on fetch access token');

        $accessToken = $client->fetchAccessTokenWithAuthCode($request->code);
        Log::info('accessToken : ' . json_encode($accessToken));
        $service = ExternalService::create([
            'user_id' => auth()->user()->id,
            'name' => 'google-drive',
            'token' => json_encode($accessToken),
        ]);
        return $service;
    }

    public function storeDataForBackup(ExternalService $service, GoogleOAuthApiClient $client)
    {
        // * Backup data Proccess
        $authUser = auth()->user();
        $tasks = Task::where('created_at', '>=', now()->subDays(7))->get();
        $jsonTasks = json_encode($tasks, JSON_PRETTY_PRINT);

        $jsonFileName = 'task_dump1.json';
        $dirSeparator = '/';
        $directoryFile = 'public' . $dirSeparator . $authUser->id . $dirSeparator;
        $directoryFileAndName = $directoryFile . $jsonFileName;
        // dd($directoryFileAndName);
        Storage::put("$directoryFileAndName", $jsonTasks);

        $zip = new ZipArchive();
        $zipFileName = storage_path('app' . $dirSeparator . $directoryFile . now()->timestamp . '-task.zip' );
        // dd($zipFileName);

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            $zipFile = storage_path('app' . $dirSeparator . $directoryFileAndName);
            // dd($zipFile);
            $zip->addFile($zipFile);
        }else {
            Log::info('Failed to open ZIP file: ' . $zipFileName);
            Log::error('Error code: ' . $zip->status);        
        }

        $zip->close();


        // * External Service Proccess
        $accessToken = $service->token['access_token'];
        $client->setAccessToken($accessToken);

        $service = new Drive($client);
        $file = new DriveFile();
        
        $file->setName("rudis_file");
        $service->files->create(
            $file,
            [
                'data' => file_get_contents($zipFileName),
                'mimeType' => 'application/octet-stream',
                'uploadType' => 'multipart'
            ]
        );

        // $service->storeData($request->all());
        return response()->json([
            'message' => 'Uploaded'
        ])->setStatusCode(Response::HTTP_OK);
    }

    private const GDRIVE_SCOPES = [
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file'
    ];

    private function customGoogleApiClientHandler(): Client
    {
        $client = app(Client::class);
        // $client = new Client();
        // $client = app(Client::class);
        // $client = app(GoogleOAuthApiClient::class);
        /* $config = config('services.google_drive');
        $client->setClientId($config['client_id']);
        $client->setClientSecret($config['client_secret']);
        $client->setRedirectUri($config['redirect_url']); */
        $client->setScopes(self::GDRIVE_SCOPES);
        return $client;
    }
}
