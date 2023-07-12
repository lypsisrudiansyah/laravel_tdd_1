<?php

namespace App\Http\Controllers;

use App\Models\ExternalService;
use Google\Client;
use Illuminate\Http\Request;
use App\CustomServices\GoogleOAuthApiClient;
use Illuminate\Support\Facades\Log;

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
