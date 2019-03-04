<!-- ========= * PHP * ===========================================================================-->

<!--    config -->

<?php
  session_start();


##   check if user already logged in ---->


if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != "yes"  || !isset($_SESSION['patient'])){
  header("Location: http://localhost/clinic/v3/login.php");
}


if(isset($_POST['appointment'])){

  $ch = curl_init();

  var_dump($_POST);

  curl_setopt_array($ch, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost/clinic/v3/api/appointment/' . $_SESSION['username'],
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
  }

}


?>
