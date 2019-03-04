<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



$app->get('/users', function (Request $request, Response $response, array $args) {

  $database = new Database();
  $db = $database->getConnection();

  $query = "SELECT * FROM `cred`";

  // prepare query statement
  $stmt = $db->prepare($query);

  $stmt->execute();

  $num = $stmt->rowCount();

  if($num > 0){
    $user = $stmt->fetchAll(PDO::FETCH_OBJ);
    $response = $response->withStatus(200)
                        ->withHeader('Content-Type', 'application/json')
                        ->write(json_encode(array("exists" => "true" , "user" => $user)));

  }
  else{

    $response = $response->withStatus(200)
                        ->withHeader('Content-Type', 'application/json')
                        ->write(json_encode(array("exists" => "false", "message" => "No such user exists")));

  }

  return $response;


});




$app->post('/user/validate', function (Request $request, Response $response, array $args) {

    $username = $request->getParam('email');
    $password = $request->getParam('pass');

    try {

      $database = new Database();
      $db = $database->getConnection();

      // select all query
      $query = "SELECT uid,uname,name,type,active FROM `cred` WHERE uname = ? and pwd = ?";

      // prepare query statement
      $stmt = $db->prepare($query);
      $username = htmlspecialchars(strip_tags($username));
      $stmt->bindParam(1,$username);
      $stmt->bindParam(2,$password);

      // execute query
      $stmt->execute();

      $num = $stmt->rowCount();

      if($num > 0){
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "true" , "user" => $user)));

      }
      else{

        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "false", "message" => "No such user exists")));

      }

    } catch (PDOException $e) {

    }

    return $response;

});



 ?>
