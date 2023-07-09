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


function googleApiClientHandler() : Client
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

Route::get('/drive', function () {
    $client = googleApiClientHandler();

    // $service = new Google\Service\Drive($client);
    Log::info('on create url');

    $url = $client->createAuthUrl();
    // return redirect($url);
    return $url;
});

Route::get('google-drive/callback', function () {
    $client = googleApiClientHandler();

    Log::info('on fetch access token');

    // $code = request('code');
    $code = $_GET['code'];
    Log::info('code: ' . $code);
    $accessToken = $client->fetchAccessTokenWithAuthCode($code);
    Log::info('accessToken : ' . json_encode($accessToken));

    uploadToGoogleDrive($accessToken['access_token']);
    
    // return $accessToken[];
    echo "Succeded Upload File :), this access expires in : " . $accessToken['expires_in'];
});


function uploadToGoogleDrive(string $accessToken)
{
    $client = new Client();
    $client->setAccessToken($accessToken);

    $service = new Google\Service\Drive($client);
    $file = new Google\Service\Drive\DriveFile();

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
}