<?php
include("action.php");
$expmsg = "";
$isexpired = 0;
$message = "";
$session_name = "";



if (isset($_POST['login'])) {
	$username = $obj->test($_POST['username']);
	$password = $obj->test($_POST['password']);
	$createdate = date('Y-m-d');
	if (!empty($username) && !empty($password)) {
		$count = $obj->login_method("user", $username, $password);
		if ($count >= 1) {
			echo "<script>location='admin/index.php' </script>";
		} else
			echo "<script>location='index.php?msg=error' </script>";
	}
	echo "<script>location='index.php?msg=blank' </script>";
} elseif (isset($_GET['msg'])) {
	$msg = $_GET['msg'];

	if ($msg == 'error') {
		$alert_type = "error";
		$notification = "Wrong User Id or Password";
	} elseif ($msg == 'blank') {
		$alert_type = "error";
		$notification = "User Id & Password Should not blank";
	} elseif ($msg == 'invalid') {
		$alert_type = "error";
		$notification = "Invalid User login";
	} elseif ($msg == 'logout') {
		$alert_type = "error";
		$notification = "Successfully Logged Out !!";
	}
	$message = "<div class='alert alert-$alert_type'><button data-dismiss='alert' class='close' type='button'>×</button>$notification</div>";
}

?>
<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Software</title>
	<link rel="stylesheet" href="css/style.default.css" type="text/css" />
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
	<script src="js/commonfun.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
	<script type="text/javascript" src="js/modernizr.min.js"></script>
	<script type="text/javascript" src="js/detectizr.min.js"></script>
	<link rel="stylesheet" href="css/LoginPage.css">
</head>

<body class="loginbody">

	<div class="loginwrapper ">
		<div class="loginwrap zindex100 card">
			<h1 class="logintitle" style="background:white;border: 1px solid #ffffff;"><span class="iconfa-lock"></span> Login <span class="subtitle">Please! Login to continue!</span></h1>
			<div class="loginwrapperinner" style="background: #74ebd5; background: -webkit-linear-gradient(to right, #ACB6E5, #74ebd5); background: linear-gradient(to right, #ACB6E5, #74ebd5);
		">
				<?php if (!empty($message)) {
					echo $message;
				} ?>
				<form id="loginform" action="" method="POST">
					<center>
						<hr style="margin:10px 0;width:40%;">
						<h1>SOFTWARE</h1>
						<hr style="margin:10px 0;width:40%;">
					</center>
					<p>
						<input type="text" id="a_username" name="username" placeholder="Username" autocomplete="off" autofocus />
					</p>
					<p>
						<input type="password" id="a_password" name="password" placeholder="Password" autocomplete="off" />
					</p>
					<p>
						<?php
						$session_name  = $obj->getvalfield("m_session", "session_name", "status = '1'");
						?>
						<input type="hidden" name="sessionid" id="sessionid" class="form-control" value="" tabindex="2" autocomplete="off" />
					<h3 align="center" style="color:#F6F8F6"><strong>Session : <?php echo $session_name; ?></strong></h3>
					</p>

					<button type="submit" name="login" onClick="return checkinputmaster('username,password')" class="btn btn-info btn-block">LOGIN</button>
					</p>
					<p style="color: red; font-size: 20px;text-align: center;">
						<?php echo $expmsg; ?>
						<center>
							<h5>Your software version : 1.1.0</h5>
						</center>
				</form>
			</div>
		</div>
	</div>

</body>

</html>