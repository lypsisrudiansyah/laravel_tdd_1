<?php

namespace App\Http\Controllers;

use App\Models\ExternalService;
use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExternalServiceController extends Controller
{
    public function connectService($serviceName)
    {
        if ($serviceName === 'google-drive') {
            $client = self::customGoogleApiClientHandler();
            $url = $client->createAuthUrl();
            
            // return $url;
            return response()->json([
                'auth_url' => $url
            ])->setStatusCode(200);
        }
    }

    public function callback(Request $request)
    {
        $client = self::customGoogleApiClientHandler();

        Log::info('on fetch access token');

        // $code = request('code');
        
        $accessToken = $client->fetchAccessTokenWithAuthCode($request->code);
        Log::info('accessToken : ' . json_encode($accessToken));
        $service = ExternalService::create([
            'user_id' => auth()->user()->id,
            'name' => 'google-drive',
            // 'token' => $accessToken,
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
        // $client = new Client();
        $client = app(Client::class);
        // $client->setAuthConfig(storage_path('app/credentials.json'));
        $config = config('services.google_drive');
        $client->setClientId($config['client_id']);
        $client->setClientSecret($config['client_secret']);
        $client->setRedirectUri($config['redirect_url']);
        $client->setScopes(self::GDRIVE_SCOPES);
        return $client;
    }
}
