<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



$app->get('/appointment/{id}', function (Request $request, Response $response, array $args) {

  $appid = $args['id'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT * FROM `appointment` WHERE appid = ?";

    // prepare query statement
    $stmt = $db->prepare($query);
    $stmt->bindParam(1,$appid);

    // execute query
    $stmt->execute();

    $num = $stmt->rowCount();

    if($num > 0){
      $appoint = $stmt->fetchAll(PDO::FETCH_OBJ);
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("exists" => "true" , "appointment" => $appoint)));

    }
    else{

      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("exists" => "false", "message" => "No such appointment exists")));

    }


  }
  catch (PDOException $e) {


  }

  return $response;

});





$app->get('/appointments/client/{uname}', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT a.appid, a.date, a.time, a.status, c.fname as cfname, c.lname as clname, d.did, d.fname as dfname, d.lname as dlname, d.verified, d.expert,d.city, d.address, d.phone, d.uname, d.fees, d.rating, d.votes
              FROM appointment as a, client as c,doctor as d
              WHERE c.uname = ? and a.did = d.did and a.pid = c.cid order by a.date,a.time";

    // prepare query statement
    $stmt = $db->prepare($query);
    $stmt->bindParam(1,$username);

    // execute query
    $stmt->execute();

    $num = $stmt->rowCount();

    if($num > 0){
      $appoint = $stmt->fetchAll(PDO::FETCH_OBJ);
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("exists" => "true" , "appointments" => $appoint)));

    }
    else{

      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("exists" => "false", "message" => "No appointments of such user exists")));

    }


  }
  catch (PDOException $e) {


  }

  return $response;

});





$app->get('/appointments/doctor/{uname}/{date}', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];
  $date = $args['date'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT a.appid, a.date, a.time, a.status, c.cid, c.fname as cfname, c.lname as clname, c.dob, c.bloodGroup, c.gender, c.phone, c.city, c.address, d.did, d.fname as dfname, d.lname as dlname
              FROM appointment as a, client as c,doctor as d
              WHERE d.uname = ? and a.pid = c.cid and a.did = d.did and a.status='Requested' and a.date= ? order by a.date,a.time";

    // prepare query statement
    $stmt = $db->prepare($query);
    $stmt->bindParam(1,$username);
    $stmt->bindParam(2,$date);

    // execute query
    $stmt->execute();

    $num = $stmt->rowCount();

    if($num > 0){
      $appoint = $stmt->fetchAll(PDO::FETCH_OBJ);
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("exists" => "true" , "appointments" => $appoint)));

    }
    else{

      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("exists" => "false", "message" => "No appointments of users exist")));

    }


  }
  catch (PDOException $e) {


  }

  return $response;

});








$app->get('/appointment/slots/{did}', function (Request $request, Response $response, array $args) {

  $did = $args['did'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT slotid,day,from_time,to_time FROM doc_timing WHERE did = ?";

    // prepare query statement
    $stmt = $db->prepare($query);
    $stmt->bindParam(1,$did);

    // execute query
    $stmt->execute();

    $num = $stmt->rowCount();

    if($num > 0){
      $appoint = $stmt->fetchAll(PDO::FETCH_OBJ);
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("exists" => "true" , "appointment" => $appoint)));

    }
    else{

      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("exists" => "false", "message" => "No such slots exist")));

    }


  }
  catch (PDOException $e) {


  }

  return $response;

});


$app->get('/appointment/available_slots/{did}', function (Request $request, Response $response, array $args) {

  $did = $args['did'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT slotid,day,from_time,to_time FROM doc_timing WHERE did = ? AND curr_users < max_allowed";

    // prepare query statement
    $stmt = $db->prepare($query);
    $stmt->bindParam(1,$did);

    // execute query
    $stmt->execute();

    $num = $stmt->rowCount();

    if($num > 0){
      $appoint = $stmt->fetchAll(PDO::FETCH_OBJ);
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("exists" => "true" , "appointment" => $appoint)));

    }
    else{

      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("exists" => "false", "message" => "No such slots exist")));

    }


  }
  catch (PDOException $e) {


  }

  return $response;

});










$app->post('/appointment/{uname}', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];
  $did = $request->getParam('did');
  $date = $request->getParam('date');
  $slotid = $request->getParam('slotid');


  try {

    $database = new Database();
    $db = $database->getConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "INSERT INTO appointment(pid, did, date, time) SELECT
    (SELECT cid from client WHERE uname= ?), ?, ?,(SELECT from_time FROM doc_timing where slotid = ? AND did= ?)
    WHERE EXISTS (SELECT slotid from doc_timing WHERE slotid = ? AND curr_users < max_allowed);
    UPDATE doc_timing SET curr_users = curr_users+1 WHERE slotid = ?;";


    $stmt = $db->prepare($query);
    $username = htmlspecialchars(strip_tags($username));


    $stmt->bindParam(1,$username);
    $stmt->bindParam(2,$did);
    $stmt->bindParam(3,$date);
    $stmt->bindParam(4,$slotid);

    $stmt->bindParam(5,$did);
    $stmt->bindParam(6,$slotid);
    $stmt->bindParam(7,$slotid);


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


$app->post('/appointment/drop/{appid}', function (Request $request, Response $response, array $args) {

  $appid = $args['appid'];

  try {

    $database = new Database();
    $db = $database->getConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "DELETE FROM `appointment` WHERE `appointment`.`appid` = ?";


    $stmt = $db->prepare($query);

    $stmt->bindParam(1,$appid);

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


?>
