<!-- ========= * PHP * ===========================================================================-->

<!--    config ---->

<?php
  session_start();


##   check if user already logged in ---->


if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != "yes" || !isset($_SESSION['doc'])){
  header("Location: http://localhost/clinic/v3/logindoc.php");
}

$status = "Requested";

if(isset($_POST['reject'])){
  $status = "Cancelled";
}
elseif(isset($_POST['approve'])){
  $status = "Approved";
}


$ch = curl_init();

curl_setopt_array($ch, array(
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_URL => 'http://localhost/clinic/v3/api/appointment/' . $_POST['appid'],
  CURLOPT_CUSTOMREQUEST => "PUT",
  CURLOPT_POSTFIELDS => http_build_query(array('status' => $status))
));

$res = json_decode(curl_exec($ch));

if($res->success == "true"){

  echo "Done";
  header("Location: http://localhost/clinic/v3/profiledoc/dashboard.php");
}
else{
  echo $res->message;
  header("Location: http://localhost/clinic/v3/profiledoc/dashboard.php");
}


?>
