<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Page-Enter" content="revealTrans(Duration=50,Transition=13)">
	<meta http-equiv="Page-Exit" content="revealTrans(Duration=50,Transition=13)">
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
<!--===============================================================================================-->
</head>
<body>


<!-- ========= * PHP * ===========================================================================-->

<!--    config ---->

<?php

#use \Psr\Http\Message\ServerRequestInterface as Request;
#use \Psr\Http\Message\ResponseInterface as Response;

session_start();


#$app = new \Slim\App;

#   check if user already logged in #

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == "yes" && isset($_SESSION['patient']) && $_SESSION['patient'] = "true"){
	header("Location: http://localhost/clinic/v3/profile/dashboard.php");
}

?>






<!---  validate user by api call------>
<?php

  header("Access-Control-Allow-Origin: *");

	if($_POST){
		$ch = curl_init();

		curl_setopt_array($ch, array(
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'http://localhost/clinic/v3/api/user/validate',
	    CURLOPT_POST => 1,
	    CURLOPT_POSTFIELDS => $_POST
		));

		$res = json_decode(curl_exec($ch));

		if($res->exists == "true" && $res->user[0]->type == "1"){


			$_SESSION['loggedIn'] = "yes";
			$_SESSION['username'] = $res->user[0]->uname;
			$_SESSION['name'] = $res->user[0]->name;
			$_SESSION['patient'] = "true";
			if($res->user[0]->active == "1"){
				$_SESSION['active'] = "true";
			}
			else {
				$_SESSION['active'] = "false";
			}

			header("Cache-Control: no-cache");
      header("Pragma: no-cache");
      header("Location: http://localhost/clinic/v3/profile/dashboard.php");
		}
		echo "Wrong Username or password";
	}

?>





<header id="myHeader">
	<div id="header-content">
	  <a href="index.html" id ="logo"><img src="img/header-logo.png" id="logoim" width="210px" height="65px"></a>
	  <nav>
	    <a href="#" id="menu-icon" ></a>
	    <ul>
	      <li><a href="index.html">Home</a></li>
	      <li><a href="about.html">About</a></li>
	      <li><a href="login.html" style="color:#9f4eb6">Login</a></li>
	      <li><a href="contact.html">Contact</a></li>
	    </ul>
	  </nav>
	</div>
</header>
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic">
					<img src="img/family.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post" action="login.php">
					<span class="login100-form-title">
						LOGIN | <h5>FAMILY</h5>
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz" ><!--form validation message-->
						<input class="input100" type="text" name="email" placeholder="Email" autofocus>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn"  id="loginbutton">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="forget.html" style="text-decoration:none">
							Password?
						</a>
					</div>
					<br/>
					<h2 class="check">Don't have an account?</h2>
					<div >
							<a href="signup.php" style="text-decoration:none"><input type=button class="login100-form-btn" style="background:silver;color:darkslategray" value="Create your Account">
							</a>
					</div>
					<div style="text-align:center;font-size:100%;padding-top:3px">
							<span class="txt1">
									Managing a doctor account?
							</span>
							<a class="txt2" href="logindoc.php" style="text-decoration:none">
									Login here
							</a>
					</div>
				</form>
			</div>
		</div>
<!--footer-->
<footer id="first">
  <div id="first-footer">
    <h4>Reach Us</h4>
  <ul class="social">
  <li><i class="fa fa-facebook"></i></li>
  <li><i class="fa fa-google-plus"></i></li>
  <li><i class="fa fa-twitter"></i></li>
  <li style="padding-right:0"><i class="fa fa-instagram"></i></li>
  </ul>
</div>
</footer>
<footer id="second">
    <p>&copy;WebClinicTech2018</p>
</footer>
<!--validating form-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
