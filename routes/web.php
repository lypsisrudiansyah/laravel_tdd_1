<?php

use Google\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/drive', function () {
    $client = new Client();
    // $client->setAuthConfig(storage_path('app/credentials.json'));
    $client->setClientId(env('GOOGLE_OAUTH_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_OAUTH_CLIENT_SECRET'));
    $client->setRedirectUri('http://localhost:8000/google-drive/callback');
    $client->setScopes([
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file'
    ]);

    // $service = new Google\Service\Drive($client);
    if (!isset($_GET['code'])) {
        $url = $client->createAuthUrl();
        return redirect($url);
    } else {
        // $code = request('code');
        $code = $_GET['code'];
        Log::info('code: ' . $code);
        $accessToken = $client->fetchAccessTokenWithAuthCode($code);
        Log::info('accessToken : ' . json_encode($accessToken));

        return $accessToken;
    }
});

Route::get('google-drive/callback', function () {
    $client = new Client([
        'verify' => false
    ]);
});
