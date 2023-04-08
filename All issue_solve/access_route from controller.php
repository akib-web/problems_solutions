<?php
// Get the Laravel instance.
$app = app();

// Get the URL from the request.
$url = $app->request->get('url');

// Use Guzzle to make a request to the URL.
$client = new \GuzzleHttp\Client();

$response = $client->request('GET', $url);

$response = $client->post('http://example.com/laravel', [
    'form_params' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]
]);

// Get the response data.
$data = json_decode($response->getBody(), true);
