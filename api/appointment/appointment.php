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





$app->get('/appointments/client/{uname}/{date}', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];
  $date = $args['date'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT a.appid, a.date, a.time, a.status, c.fname as cfname, c.lname as clname, d.did, d.fname as dfname, d.lname as dlname, d.verified, d.expert,d.city, d.address, d.phone, d.uname, d.fees, d.rating, d.votes
              FROM appointment as a, client as c,doctor as d
              WHERE c.uname = ? and a.did = d.did and a.pid = c.cid and a.date >= ? order by a.date,a.time";

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
                          ->write(json_encode(array("exists" => "false", "message" => "No appointments of such user exists")));

    }


  }
  catch (PDOException $e) {


  }

  return $response;

});





$app->get('/appointments/doctor/queued/{uname}/{date}', function (Request $request, Response $response, array $args) {

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



$app->get('/appointments/doctor/approved/{uname}/{date}', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];
  $date = $args['date'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT a.appid, a.date, a.time, a.status, c.cid, c.fname as cfname, c.lname as clname, c.dob, c.bloodGroup, c.gender, c.phone, c.city, c.address, d.did, d.fname as dfname, d.lname as dlname
              FROM appointment as a, client as c,doctor as d
              WHERE d.uname = ? and a.pid = c.cid and a.did = d.did and a.status='Approved' and a.date >= ? order by a.date,a.time";

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




$app->get('/appointment/slots/{uname}', function (Request $request, Response $response, array $args) {

  $uname = $args['uname'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT * FROM doc_timing WHERE did = (SELECT did FROM doctor WHERE uname = ? )";

    // prepare query statement
    $stmt = $db->prepare($query);
    $stmt->bindParam(1,$uname);

    // execute query
    $stmt->execute();

    $num = $stmt->rowCount();

    if($num > 0){
      $slots = $stmt->fetchAll(PDO::FETCH_OBJ);
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("exists" => "true" , "slots" => $slots)));

    }
    else{

      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("exists" => "false", "message" => "No slots exist")));

    }


  }
  catch (PDOException $e) {


  }

  return $response;

});



$app->get('/appointment/available_slots/{did}/{date}', function (Request $request, Response $response, array $args) {

  $did = $args['did'];
  $date = $args['date'];
  $day = date("l", strtotime($date));

  try {

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT d.slotid,day,from_time,to_time, (d.max_allowed - IFNULL(b.curr_users,0)) as free_slots FROM (SELECT * FROM doc_timing WHERE did= ? AND day= ?) as d LEFT JOIN booking as b ON d.slotid = b.slotid AND b.date = ? ";

    // prepare query statement
    $stmt = $db->prepare($query);
    $stmt->bindParam(1,$did);
    $stmt->bindParam(2,$day);
    $stmt->bindParam(3,$date);

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





$app->post('/appointment/slots/{uname}', function (Request $request, Response $response, array $args) {

  $uname = $args['uname'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $query = "INSERT INTO doc_timing(did, day, from_time, to_time, max_allowed) VALUES((SELECT did FROM doctor WHERE uname= ?), ?, ?, ?, ?)";

    // prepare query statement
    $stmt = $db->prepare($query);
    $stmt->bindParam(1,$uname);
    $stmt->bindParam(2,$request->getParam('day'));
    $stmt->bindParam(3,$request->getParam('from_time'));
    $stmt->bindParam(4,$request->getParam('to_time'));
    $stmt->bindParam(5,$request->getParam('max_allowed'));


    // execute query
    $stmt->execute();

    $num = $stmt->rowCount();

    if($num > 0){
      //$slots = $stmt->fetchAll(PDO::FETCH_OBJ);
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("success" => "true" , "message" => "Done")));

    }
    else{

      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("success" => "false", "message" => "Record Exists")));

    }


  }
  catch (PDOException $e) {


  }

  return $response;

});




$app->delete('/appointment/slots/{uname}/delete/{slotid}', function (Request $request, Response $response, array $args) {

  $uname = $args['uname'];
  $slotid = $args['slotid'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $query = "DELETE FROM `doc_timing` WHERE `slotid` = ? AND `did` = (SELECT did from doctor where uname = ?) ";

    // prepare query statement
    $stmt = $db->prepare($query);
    $stmt->bindParam(1,$slotid);
    $stmt->bindParam(2,$uname);


    // execute query
    $stmt->execute();

    $num = $stmt->rowCount();

    if($num > 0){
      //$slots = $stmt->fetchAll(PDO::FETCH_OBJ);
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("success" => "true" , "message" => "Deleted Slot")));

    }
    else{

      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("success" => "false", "message" => "Delete slot failed")));

    }


  }
  catch (PDOException $e) {


  }

  return $response;

});




$app->post('/appointment/{uname}', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];
  $did = $request->getParam('docid');
  $date = $request->getParam('bookdate');
  $slotid = $request->getParam('slotid');


  try {

    $database = new Database();
    $db = $database->getConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "INSERT INTO booking (date,slotid) VALUES (? , ?) ON DUPLICATE KEY UPDATE curr_users = curr_users+1;
              INSERT INTO appointment(pid, did, date, time, slotid) VALUES
              ((SELECT cid from client WHERE uname= ?), ?, ?,(SELECT from_time FROM doc_timing where slotid = ?), ?);";


    $stmt = $db->prepare($query);
    $username = htmlspecialchars(strip_tags($username));

    $stmt->bindParam(1,$date);
    $stmt->bindParam(2,$slotid);

    $stmt->bindParam(3,$username);
    $stmt->bindParam(4,$did);
    $stmt->bindParam(5,$date);
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


$app->put('/appointment/{appid}', function (Request $request, Response $response, array $args) {

  $appid = $args['appid'];
  $status = $request->getParam('status');


  $num =0;

  try {

    $database = new Database();
    $db = $database->getConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query1 = "UPDATE `appointment` SET `status` = ? WHERE `appointment`.`appid` = ?;";
    $query2 = "UPDATE `appointment` SET `status` = ? WHERE `appointment`.`appid` = ?;
                UPDATE `booking` SET curr_users = curr_users - 1 WHERE row(slotid, date) IN (SELECT slotid, date from appointment WHERE appid = ?)";

    if($status == "Approved"){
      $stmt = $db->prepare($query1);

      $stmt->bindParam(1,$status);
      $stmt->bindParam(2,$appid);

      $stmt->execute();
      $num = $stmt->rowCount();
    }
    elseif ($status == "Cancelled") {
      $stmt = $db->prepare($query2);

      $stmt->bindParam(1,$status);
      $stmt->bindParam(2,$appid);
      $stmt->bindParam(3,$appid);

      $stmt->execute();
      $num = $stmt->rowCount();
    }



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
