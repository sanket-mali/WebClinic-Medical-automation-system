<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



$app->get('/doctor/{uname}', function (Request $request, Response $response, array $args) {
    $username = $args['uname'];

    try {

      $database = new Database();
      $db = $database->getConnection();

      // select all query
      $query = "SELECT * FROM `doctor` WHERE uname = ?";

      // prepare query statement
      $stmt = $db->prepare($query);
      $username = htmlspecialchars(strip_tags($username));
      $stmt->bindParam(1,$username);

      // execute query
      $stmt->execute();

      $num = $stmt->rowCount();

      if($num > 0){
        $doc = $stmt->fetchAll(PDO::FETCH_OBJ);
        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "true" , "doctor" => $doc)));

      }
      else{

        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "false", "message" => "No such doctor exists")));

      }

    } catch (PDOException $e) {


    }

    return $response;

});




$app->post('/doctor/{uname}', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];
  // print_r($args);
  if($request->getParam('pass') != $request->getParam('cpass')){
    echo json_encode(array("success" => "false", "message" => "passwords don't match"));
  }

  try {

    $database = new Database();
    $db = $database->getConnection();

    // select all query
    $query1 = "INSERT INTO cred (uname, pwd, name, joined, type, active) VALUES (?, ?, ?, CURRENT_TIMESTAMP, '0', '0')";
    $query2 = "INSERT INTO doctor (uname) VALUES (?)";

    $stmt = $db->prepare($query1);
    $username = htmlspecialchars(strip_tags($username));
    $stmt->bindParam(1,$username);
    $stmt->bindParam(2,$request->getParam('pass'));
    $stmt->bindParam(3,$request->getParam('name'));



    $stmt->execute();
    // $stmt->debugDumpParams();

    $num = $stmt->rowCount();

    if($num > 0){

      $db1 = $database->getConnection();

      $stmt1 = $db1->prepare($query2);
      $username = htmlspecialchars(strip_tags($username));

      $stmt1->bindParam(1,$username);

      $stmt1->execute();

      $num1 = $stmt1->rowCount();

      if($num1 > 0){
        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("success" => "true")));
      }

    }
    else{
        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("success" => "false", "message" => "Username already taken")));
    }

  }
  catch(PDOException $e){

  }

  return $response;


});




$app->put('/doctor/update/{uname}', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // select all query
    $query = "UPDATE doctor SET fname= ?,lname= ?, email= ?, dob= ?, expert= ?, phone= ?,address= ?,city= ?,country= ?,postal= ?,about= ? WHERE uname = ? ";
    $stmt = $db->prepare($query);

    $username = htmlspecialchars(strip_tags($username));

    $odate = $request->getParam('dob');
    $bdate = date("Y-m-d",strtotime(str_replace('/', '-',$request->getParam('dob'))));

    $stmt->bindParam(1,$request->getParam('fname'));
    $stmt->bindParam(2,$request->getParam('lname'));
    $stmt->bindParam(3,$request->getParam('email'));
    $stmt->bindParam(4,$bdate);
    $stmt->bindParam(5,$request->getParam('expert'));
    $stmt->bindParam(6,$request->getParam('phone'));
    $stmt->bindParam(7,$request->getParam('address'));
    $stmt->bindParam(8,$request->getParam('city'));
    $stmt->bindParam(9,$request->getParam('country'));
    $stmt->bindParam(10,$request->getParam('postal'));
    $stmt->bindParam(11,$request->getParam('about'));
    $stmt->bindParam(12,$username);

    // execute query
    $stmt->execute();
    $num = $stmt->rowCount();

    if($num > 0 ){
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("success" => "true" , "message" => "Done")));
    }
    else{
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("success" => "false", "message" => "Error")));
    }

  }
  catch (PDOException $e) {
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("success" => "false", "message" => $e->getMessage())));

  }

  return $response;

});



$app->put('/doctor/update/{uname}/image', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // select all query
    $query = "UPDATE `doctor` SET `imid`=? WHERE `uname` = ?";
    $stmt = $db->prepare($query);

    $username = htmlspecialchars(strip_tags($username));

    $stmt->bindParam(1,$request->getParam('imid'));
    $stmt->bindParam(2,$username);

    // execute query
    $stmt->execute();
    $num = $stmt->rowCount();


    if($num > 0 ){
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("success" => "true" , "message" => "Upload Done")));
    }
    else{
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("success" => "false", "message" => "Error")));
    }

  }
  catch (PDOException $e) {
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("success" => "false", "message" => $e->getMessage())));

  }

  return $response;

});



$app->get('/doctor/{location}/{expert}', function (Request $request, Response $response, array $args) {
    $location = "%".$args['location']."%";
    $expert = "%".$args['expert']."%";


    try {

      $database = new Database();
      $db = $database->getConnection();

      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // select all query
      $query = "SELECT * FROM `doctor` WHERE city LIKE ? AND expert LIKE ?";

      // prepare query statement
      $stmt = $db->prepare($query);
      $stmt->bindParam(1,$location);
      $stmt->bindParam(2,$expert);

      // execute query
      $stmt->execute();

      $num = $stmt->rowCount();

      if($num > 0){
        $doc = $stmt->fetchAll(PDO::FETCH_OBJ);
        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "true" , "doctor" => $doc)));

      }
      else{

        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "false", "message" => "No such doctor exists")));

      }

    } catch (PDOException $e) {


    }

    return $response;

});



?>
