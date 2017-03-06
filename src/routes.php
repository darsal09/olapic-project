<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    $client = new \GuzzleHttp\Client();
    $result = [];
    $error = '';
    try {
        $result = $client->request('GET', 'https://photorankapi-a.akamaihd.net', [ 'query' =>[
            'auth_token' => '0a40a13fd9d531110b4d6515ef0d6c529acdb59e81194132356a1b8903790c18',
            'version' => 'v2.2'
        ]]);
        // Render index view
        $result = json_decode( $result->getBody()->getContents(), true )['data']['_embedded'];
    }catch (\GuzzleHttp\Exception\RequestException $e){
        $error = $e->getMessage();
    }
    return  $this->renderer->render($response, 'index.phtml', [ 'args' => $args, 'result' => $result, 'error' => $error]);
});

$app->get( '/customers/{id}/{media_type}', function( $request, $response, $args ){

    $client = new \GuzzleHttp\Client(
//    ['base_ur' => 'https://photorankapi-a.akamaihd.net',]
    );
    $result = [];
    try {
        $result = $client->request('GET', 'https://photorankapi-a.akamaihd.net/customers/'.$args['id'].'/media/'.$args['media_type' ], [ 'query' =>[
            'auth_token' => '0a40a13fd9d531110b4d6515ef0d6c529acdb59e81194132356a1b8903790c18',
            'version' => 'v2.2'
        ]]);
        $result = json_decode( $result->getBody()->getContents(), true )['data']['_embedded']['media'];

        return $response->withJson( $result, 200 );
    }catch (\GuzzleHttp\Exception\RequestException $e){
       return $response->withJson( $result, 500);
    }

} );

