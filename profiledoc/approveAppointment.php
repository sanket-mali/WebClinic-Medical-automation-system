<!-- ========= * PHP * ===========================================================================-->

<!--    config ---->

<?php
  session_start();


##   check if user already logged in ---->


if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != "yes" || $_SESSION['doc'] != "true"){
  header("Location: http://localhost/clinic/v3/logindoc.php");
}


if(isset($_POST['reject'])){

  $ch = curl_init();

  curl_setopt_array($ch, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost/clinic/v3/api/appointment/drop/' . $_POST['appid'],
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $_POST
  ));

  $res = json_decode(curl_exec($ch));

  if($res->success == "true"){

    echo "Done";
    header("Location: http://localhost/clinic/v3/profile/dashboard.php");
  }
  else{
    echo $res->message;
    header("Location: http://localhost/clinic/v3/profile/dashboard.php");
  }

}


?>
