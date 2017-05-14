<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'api/v1/'], function ($app) {

    $app->group(['prefix' => 'tracks/'], function ($app) {
        $app->get('/', 'TracksController@index');
        $app->post('/all','TracksController@createTracks');
    });

    $app->group(['prefix' => 'settings/'], function ($app) {
        $app->get('/', 'SettingsController@index');
        $app->get('/soundcloud-client-id','SettingsController@getSoundcloudClientId');
        $app->post('/soundcloud-client-id','SettingsController@setSoundcloudClientId');
    });

    $app->group(['prefix' => 'tickets/'], function ($app) {
        $app->get('/', 'TicketsController@index');

        $app->group(['prefix' => 'checkout/'], function ($app) {
            $app->post('/', 'TicketsController@createOrder');
            $app->put('/', 'TicketsController@editOrder');

            $app->group(['prefix' => 'payment/'], function ($app) {
                $app->post('/create', 'TicketsController@createPayment');
                $app->post('/execute', 'TicketsController@executePayment');
            });
        });

    });

});
