<?php

use Google\Client;
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
    $url = $client->createAuthUrl();
    return $url;

});