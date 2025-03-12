<?php
include("../action.php");

if (isset($_COOKIE['inchilly_username']))
  $inchilly_username = $_COOKIE['inchilly_username'];
else
  $inchilly_username = "";

if (isset($_COOKIE['inchilly_password']))
  $inchilly_password = $_COOKIE['inchilly_password'];
else
  $inchilly_password = "";

if (isset($_POST['login'])) {
  $username = $obj->test_input($_POST['username']);
  $password = $obj->test_input($_POST['password']);

  if ($username != "" && $password != "") {
    $is_exist = $obj->login_method("user", $username, $password);

    if ($is_exist > 0) {
      echo "<script>location='dashboard.php'</script>";
    } else {
      //redirect to login

      echo "<script>location='index.php'</script>";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Indian Chilly</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=yes, viewport-fit=cover user-scalable=no">
  <link rel="stylesheet" href="materialize/css/materialize.min.css">
  <link rel="stylesheet" href="materialize/css/icon.css">
  <link rel="stylesheet" href="materialize/css/animate.min.css" />
  <style>
    body {
      background: #141E30;
      background: -webkit-linear-gradient(to bottom, #243B55, #141E30);
      background: linear-gradient(to bottom, #243B55, #141E30);
    }

    .text {
      background: #FFB76B;
      background: -webkit-linear-gradient(to right, #FFB76B 0%, #FFA73D 30%, #FF7C00 60%, #FF7F04 100%);
      background: -moz-linear-gradient(to right, #FFB76B 0%, #FFA73D 30%, #FF7C00 60%, #FF7F04 100%);
      background: linear-gradient(to right, #FFB76B 0%, #FFA73D 30%, #FF7C00 60%, #FF7F04 100%);
      -webkit-text-fill-color: transparent;
      text-transform: uppercase;
      font-weight: 700;
      text-shadow: 2px 8px 6px rgb(0 0 0 / 24%), 0px -5px 16px rgb(255 255 255 / 12%);
    }
  </style>
</head>

<body>
  <!-- login page -->
  <section style="height: 100vh;">
    <div class="container">
      <div class="row">
        <div class="col s12 center"><br>
          <!-- <h2 class="text">Indian Chilly</h2> -->
          <div class="col s6 offset-s3">
            <img src="../admin/images/mohandhaba_logo_app.png" alt="" style="margin-top: 40px;width: 220px;margin-left: -38px;">
          </div>
          <br>
        </div>
      </div>
      <div class="row">
        <form action="" method="POST" class="col s12">
          <h4 class="white-text">Log In</h2>
            <h6 class="left-align white-text" style="margin-bottom:50px;">Login to access your account.</h6>
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix white-text">account_circle</i>
                <input id="username" name="username" type="text" value="<?php echo $inchilly_username; ?>" class="validate white-text">
                <label for="username">User Name</label>
              </div>
              <div class="input-field col s12">
                <i class="material-icons prefix white-text">lock</i>
                <input id="password" name="password" type="password" value="<?php echo $inchilly_password; ?>" class="validate  white-text">
                <label for="password">Password</label>
              </div>
              <!--  <div class="input-field col s12 right-align">
              <a href="javascript:void(0);" class="forget_pass white-text">Forget Passwrod ?</a>
            </div> -->
              <div class="input-field col s12 center">
                <input type="submit" name="login" class="btn orange darken-3 z-depth-3" style="width: 60%;border-radius:20px;" onClick="return checkinputmaster('username,password'); " value="LogIn" />
              </div>
            </div>
        </form>
      </div>
    </div>
  </section>
  <script src="materialize/js/jquery.min.js"></script>
  <script src="materialize/js/materialize.min.js"></script>
  <script src="materialize/js/app.js"></script>
  <script src="js/commonfun2.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <?php

  $msg = "";

  if (isset($_GET['msg'])) {

    $msg = $obj->test_input($_GET['msg']);

    if ($msg == 'faild') { ?>

      <script type="text/javascript">
        swal({

          title: "Invalid Login Details!",

          text: "You entered invalid id or password",

          icon: "error",

          button: "Try Again",

        });
      </script>

  <?php

    }
  }

  ?>

</body>

</html>