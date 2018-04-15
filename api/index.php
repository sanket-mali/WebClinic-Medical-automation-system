<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'config/database.php';

$app = new \Slim\App;


#include_once(dirname(__FILE__) .'/client/client.php');
require 'user/user.php';
require 'client/client.php';
require 'doctor/doctor.php';
require 'appointment/appointment.php';

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});


$app->run();
