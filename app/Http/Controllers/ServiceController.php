<?php

namespace App\Http\Controllers;

use Google\Client;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function connectService(Request $request)
    {
        if ($request->service === 'google-drive') {
            $client = googleApiClientHandler();
            $url = $client->createAuthUrl();
            
            return $url;
        }
    }

    private function googleApiClientHandler(): Client
    {
        $client = new Client();
        // $client->setAuthConfig(storage_path('app/credentials.json'));
        $client->setClientId(env('GOOGLE_OAUTH_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_OAUTH_CLIENT_SECRET'));
        $client->setRedirectUri('http://localhost:8000/google-drive/callback');
        $client->setScopes([
            'https://www.googleapis.com/auth/drive',
            'https://www.googleapis.com/auth/drive.file'
        ]);
        return $client;
    }
}
