<?php

namespace App\Http\Controllers;

use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    public function connectService(Request $request)
    {
        if ($request->service === 'google-drive') {
            $client = self::googleApiClientHandler();
            $url = $client->createAuthUrl();
            
            // return $url;
            return response()->json([
                'auth_url' => $url
            ])->setStatusCode(200);
        }
    }

    public function callback(Request $request)
    {
        $client = googleApiClientHandler();

        Log::info('on fetch access token');

        // $code = request('code');
        $code = $_GET['code'];
        Service
        Log::info('code: ' . $code);
        $accessToken = $client->fetchAccessTokenWithAuthCode($request->code);
        Log::info('accessToken : ' . json_encode($accessToken));
        return $accessToken;
   
    }

    private const GDRIVE_SCOPES = [
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file'
    ]; 

    private function googleApiClientHandler(): Client
    {
        $client = new Client();
        // $client->setAuthConfig(storage_path('app/credentials.json'));
        $config = config('services.google_drive');
        $client->setClientId($config['client_id']);
        $client->setClientSecret($config['client_secret']);
        $client->setRedirectUri($config['redirect_url']);
        $client->setScopes(self::GDRIVE_SCOPES);
        return $client;
    }
}
