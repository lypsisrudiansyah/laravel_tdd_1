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


/* private function googleApiClientHandler() : Client
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
} */

/* Route::get('/drive', function () {
    $client = googleApiClientHandler();

    // $service = new Google\Service\Drive($client);
    // Log::info('on create url');

    $url = $client->createAuthUrl();
    // return redirect($url);
    return $url;
});


 */
Route::get('google-drive/callback', function () {
    if (request('state') == env('CODE_FOR_CALLBACK')) {
        return response()->json([
            'code' => request('code'),
            'status' => 'confirmed',
        ], 200);
    } else {
        return response()->json([
            'status' => 'unknown response, unauthorized',
        ], 400);
    }
});
