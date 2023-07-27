<?php
use Google\Client;

function lypsisJsonResponse(int $statusCode, string $message, $data = null)
{
    $response = [
        'status' => $statusCode,
        'message' => $message,
    ];

    if (!is_null($data)) {
        $response['data'] = $data;
    }

    return response()->json($response, $statusCode);
}

function googleApiClientHandler() : Client
{
    $client = new Client();
    // $client->setAuthConfig(storage_path('app/credentials.json'));
    $client->setClientId(env('GOOGLE_OAUTH_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_OAUTH_CLIENT_SECRET'));
    $client->setState(env('CODE_FOR_CALLBACK')));
    $client->setRedirectUri('http://localhost:8000/google-drive/callback');
    $client->setScopes([
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file'
    ]);
    return $client;
}

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