<?php

namespace App\Http\Controllers;

use App\Models\ExternalService;
use Google\Client;
use Illuminate\Http\Request;
use App\CustomServices\GoogleOAuthApiClient;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

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

    public function storeData(ExternalService $service, GoogleOAuthApiClient $client)
    {
        // dd($service->token['access_token']);
        $accessToken = $service->token['access_token'];
        $client->setAccessToken($accessToken);

        $service = new Drive($client);
        $file = new DriveFile();

        $fileToUpload = '';

        DEFINE("TESTFILE", 'testfile-small.txt');
        if (!file_exists(TESTFILE)) {
            $fh = fopen(TESTFILE, 'w');
            fseek($fh, 1024 * 1024);
            fwrite($fh, "!", 1);
            fclose($fh);
        }
        
        $file->setName("rudis_file");
        $result2 = $service->files->create(
            $file,
            [
                'data' => file_get_contents(TESTFILE),
                'mimeType' => 'application/octet-stream',
                'uploadType' => 'multipart'
            ]
        );

        // $service->storeData($request->all());
        return response()->json([
            'message' => 'Uploaded'
        ])->setStatusCode(Response::HTTP_CREATED);
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
