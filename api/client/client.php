<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



$app->get('/client/{uname}', function (Request $request, Response $response, array $args) {
    $username = $args['uname'];

    try {

      $database = new Database();
      $db = $database->getConnection();

      // select all query
      $query = "SELECT * FROM `client` WHERE uname = ?";

      // prepare query statement
      $stmt = $db->prepare($query);
      $username = htmlspecialchars(strip_tags($username));
      $stmt->bindParam(1,$username);

      // execute query
      $stmt->execute();

      $num = $stmt->rowCount();

      if($num > 0){
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "true" , "client" => $user)));

      }
      else{

        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "false", "message" => "No such client exists")));

      }

    } catch (PDOException $e) {


    }

    return $response;

});






$app->post('/client/{uname}', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];
  // print_r($args);
  if($request->getParam('pass') != $request->getParam('cpass')){
    $response = $response->withStatus(200)
                        ->withHeader('Content-Type', 'application/json')
                        ->write(json_encode(array("success" => "false", "message" => "passwords don't match")));
  }
  else{

    try {

      $database = new Database();
      $db = $database->getConnection();

      // select all query
      $query1 = "INSERT INTO cred (uname, pwd, name, joined, type, active) VALUES (?, ?, ?, CURRENT_TIMESTAMP, '1', '1')";
      $query2 = "INSERT INTO client (uname, fname) VALUES (?, ?)";

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
        $stmt1->bindParam(2,$request->getParam('name'));

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
  }

  return $response;


});





$app->put('/client/update/{uname}', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // select all query
    $query = "UPDATE `client` SET `fname`= ?,`lname`= ?,`gender`= ?, `email`= ?, `dob`= ?, `bloodGroup` = ?, `phone`= ?,`address`= ?,`city`= ?,`country`= ?,`postal`= ?,`about`= ? WHERE `uname` = ? ";
    $stmt = $db->prepare($query);

    $username = htmlspecialchars(strip_tags($username));

    $odate = $request->getParam('dob');
    $bdate = date("Y-m-d",strtotime(str_replace('/', '-',$request->getParam('dob'))));

    $stmt->bindParam(1,$request->getParam('fname'));
    $stmt->bindParam(2,$request->getParam('lname'));
    $stmt->bindParam(3,$request->getParam('gender'));
    $stmt->bindParam(4,$request->getParam('email'));
    $stmt->bindParam(5,$bdate);
    $stmt->bindParam(6,$request->getParam('bloodGroup'));
    $stmt->bindParam(7,$request->getParam('phone'));
    $stmt->bindParam(8,$request->getParam('address'));
    $stmt->bindParam(9,$request->getParam('city'));
    $stmt->bindParam(10,$request->getParam('country'));
    $stmt->bindParam(11,$request->getParam('postal'));
    $stmt->bindParam(12,$request->getParam('about'));
    $stmt->bindParam(13,$username);

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




$app->put('/client/update/{uname}/image', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];

  try {

    $database = new Database();
    $db = $database->getConnection();

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // select all query
    $query = "UPDATE `client` SET `imid`=? WHERE `uname` = ?";
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







$app->get('/client/{rpid}/medicines', function (Request $request, Response $response, array $args) {

  $rpid = $args['rpid'];

  try {

      $database = new Database();
      $db = $database->getConnection();

      // select all query
      $query = "SELECT * FROM medicine_rec  WHERE rpid = ?";

      // prepare query statement
      $stmt = $db->prepare($query);
      #$username = htmlspecialchars(strip_tags($username));
      $stmt->bindParam(1,$rpid);

      // execute query
      $stmt->execute();

      $num = $stmt->rowCount();



      if($num > 0){
        $rec = $stmt->fetchAll(PDO::FETCH_OBJ);

        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "true" , "record" => $rpid , "medicines" => $rec)));

      }
      else{

        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "false", "message" => "No medicines exists")));

      }

    } catch (PDOException $e) {


    }

    return $response;

});


$app->get('/client/{cid}/allrecords', function (Request $request, Response $response, array $args) {

  $cid = $args['cid'];

  try {

      $database = new Database();
      $db = $database->getConnection();

      // select all query
      $query = "SELECT * FROM `record_pat` WHERE pid = ? ORDER BY date DESC";

      // prepare query statement
      $stmt = $db->prepare($query);
      #$username = htmlspecialchars(strip_tags($username));
      $stmt->bindParam(1,$cid);

      // execute query
      $stmt->execute();

      $num = $stmt->rowCount();



      if($num > 0){
        $rec = $stmt->fetchAll(PDO::FETCH_OBJ);

        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "true" , "client" => $cid , "records" => $rec)));

      }
      else{

        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "false", "message" => "No record exists")));

      }

    } catch (PDOException $e) {


    }

    return $response;

});








$app->get('/client/{uname}/record', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];

  try {

      $database = new Database();
      $db = $database->getConnection();

      // select all query
      $query = "SELECT * FROM `record_pat` WHERE pid IN (SELECT cid FROM `client` WHERE uname = ?)";

      // prepare query statement
      $stmt = $db->prepare($query);
      $username = htmlspecialchars(strip_tags($username));
      $stmt->bindParam(1,$username);

      // execute query
      $stmt->execute();

      $num = $stmt->rowCount();



      if($num > 0){
        $rec = $stmt->fetchAll(PDO::FETCH_OBJ);

        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "true" , "client" => $username , "records" => $rec)));

      }
      else{

        $response = $response->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write(json_encode(array("exists" => "false", "message" => "No record exists")));

      }

    } catch (PDOException $e) {


    }

    return $response;

});





$app->post('/client/{uname}/record', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];

  try {

    $database = new Database();
    $db = $database->getConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "INSERT INTO `record_pat` (`pid`, `did`, `date`, `diagnosis`, `prescid`) VALUES ((SELECT `cid` FROM `client` WHERE `uname` = ? ), NULL, ? , NULL , ?)";


    $stmt = $db->prepare($query);
    $username = htmlspecialchars(strip_tags($username));
    $rdate = date("Y-m-d",strtotime(str_replace('/', '-',$request->getParam('date'))));


    $stmt->bindParam(1,$username);
    $stmt->bindParam(2,$rdate);
    #$stmt->bindParam(3,$request->getParam('diagnosis'));
    $stmt->bindParam(3,$request->getParam('file_name'));

    $stmt->execute();
    $num = $stmt->rowCount();

    if($num > 0 ){
      $rpid = $db->lastInsertId();
      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("success" => "true" , "message" => "Done", "rpid" => $rpid)));
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




$app->put('/client/{uname}/record', function (Request $request, Response $response, array $args) {

  $username = $args['uname'];
  $dname = $request->getParam('dname');
  $diagnosis = $request->getParam('diagnosis');
  $rpid = $request->getParam('rpid');

  try {

    $database = new Database();
    $db = $database->getConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "UPDATE `record_pat` SET dname=?, diagnosis = ? WHERE rpid = ?";


    $stmt = $db->prepare($query);
    $username = htmlspecialchars(strip_tags($username));
    #$rdate = date("Y-m-d",strtotime(str_replace('/', '-',$request->getParam('date'))));


    $stmt->bindParam(1,$dname);
    $stmt->bindParam(2,$diagnosis);
    $stmt->bindParam(3,$rpid);

    #$stmt->bindParam(3,$request->getParam('file_name'));

    $stmt->execute();
    $num = $stmt->rowCount();


    # ----- get medicines ---------- #

    $database = new Database();
    $db = $database->getConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "INSERT INTO medicine_rec(rpid, mname, time,repetition, duration) VALUES ";
    $query_temp = "(?, ?, ?, ?, ?)";
    $meds = 0;

    for($i = 0 ; ; $i++){
      if($request->getParam('mname'. $i) !== null){
        $meds++;
        $query = $i == 0 ? $query . $query_temp : $query . ", " . $query_temp;
      }
      else{
        break;
      }
    }

    $stmt = $db->prepare($query);
    $par = 0;

    for($i = 0 ; $i < $meds; $i++){
      $mname = $request->getParam('mname'. $i);
      $time = $request->getParam('time'. $i);
      $repetition = $request->getParam('repetition'. $i);
      $duration = $request->getParam('duration'. $i);

      $stmt->bindValue($par + 1,$rpid);
      $stmt->bindValue($par + 2,$mname);
      $stmt->bindValue($par + 3,$time);
      $stmt->bindValue($par + 4,$repetition);
      $stmt->bindValue($par + 5,$duration);

      $par += 5;

    }

    $stmt->execute();
    $num = $stmt->rowCount();


    # ------------------------------ #

    if($num > 0 ){

      $response = $response->withStatus(200)
                          ->withHeader('Content-Type', 'application/json')
                          ->write(json_encode(array("success" => "true" , "message" => "Done", "rec" => $num, "query" => $query)));
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
