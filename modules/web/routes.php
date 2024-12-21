<?php

$router->get('/', 'WelcomeController@show');
$router->get('/krs', 'KRSController@index');
$router->post('/krs', 'KRSController@store');