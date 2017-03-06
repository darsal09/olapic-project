<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    $client = new \GuzzleHttp\Client(
//    ['base_ur' => 'https://photorankapi-a.akamaihd.net',]
    );


try {
    $result = $client->request('GET', 'https://photorankapi-a.akamaihd.net', [ 'query' =>[
        'auth_token' => '0a40a13fd9d531110b4d6515ef0d6c529acdb59e81194132356a1b8903790c18',
        'version' => 'v2.2'
    ]]);
    // Render index view
    $result = json_decode( $result->getBody()->getContents(), true )['data']['_embedded'];
}catch (\GuzzleHttp\Exception\RequestException $e){
    //echo $e->getMessage().PHP_EOL;
    //echo \GuzzleHttp\Psr7\str($e->getRequest()).PHP_EOL;
}
    return  $this->renderer->render($response, 'index.phtml', [ 'args' => $args, 'result' => $result]);
});

$app->get( '/customers', function( $request, $response, $args ){
    $result = [ 'customers' => [
            [
                'id' => 1,
                'name' => 'Darwin',
            ],
            [
                'id' => 2,
                'name' => 'Nicole',
            ]
        ]
    ];

    //print_r( json_encode($result ) );
    return $response->withJson( $result, 200 );
});

$app->get( '/customers/{id}', function( $request, $response, $args ){

    $images = ['customer' => [ 'images' =>[
                                                        [
                                                            'name' => 'https://z1photorankmedia-a.akamaihd.net/media/3/n/r/3nr3zz3/original.jpg',
                                                            "id"=> "2581812751",
                                                        ]
                                                    ]
    ]];

        return $response->withJson( $images, 200);
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
        // Render index view
        $result = json_decode( $result->getBody()->getContents(), true )['data']['_embedded']['media'];
       // print_r( json_encode( $result ) );


        return $response->withJson( $result );

    }catch (\GuzzleHttp\Exception\RequestException $e){
        echo $e->getMessage().PHP_EOL;
        //echo \GuzzleHttp\Psr7\str($e->getRequest()).PHP_EOL;
    }

} );

