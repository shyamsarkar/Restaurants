<?php
include("action.php");

$message = "";
$session_name = "";

if (isset($_POST['submit'])) {

  $email = $_POST['email'];

  $pwd = $obj->getvalfield("user", "password", "email='$email'");

  if ($pwd > 0) {
    $to = "example@demo.com";
    $subject = "Visitor Want To Contact:";
    $message = "
               <table width='100%' border='0' cellpadding='0'>
                  <tr>
                     <td align='center' valign='top' bgcolor='#993300' style='background-color:#993333;'><br>
                
                     <table width='96%' border='0' cellspacing='0' cellpadding='0' style='border:3px solid #564319;border-radius:10px;background-color:#993333;'>
                      <tr>
                         <td align='center' valign='top' bgcolor='#564319' style='background-color:#564319; font-family:Arial, Helvetica, sans-serif; padding:10px;'><div style='font-size:30px; color:#ffffff;'><b>WATTO </b></div>
                      </td>
                  </tr>
                 </table> 
                 </td>
                 </tr> 
               <tr>   
              <td align='left' valign='top' bgcolor='#ffffff' style='background-color:#CCC; border:3px dashed #900'>
                    <br/>
                      <div style='font-size:22px; color:#FF0000; margin-left:10px; font-weight:bold'></div>
                    <table width='100%' border='1' cellspacing='0' cellpadding='0' style='background-color:#CCC;'>
              
            
               <tr>
                <td><span style='margin-left:5px;'>Email  :</span></td>
                <td colspan='3'><span style='margin-left:5px;'>$email</span></td>
                
              </tr>
              <tr>
                <td><span style='margin-left:5px;'>Password :</span></td>
                <td colspan='3'><span style='margin-left:5px;'>$pwd</span></td>
                
              </tr>
              
              </table>      
            </td></tr>
            </table>
        ";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html;charset=iso-8859-1' . "\r\n";
    $headers .= "From: $email";

    mail($to, $subject, $message, $headers);
    echo "<script>location='index.php';</script>";
  } else {
    $message = "<div class='alert alert-error'><button data-dismiss='alert' class='close' type='button'>×</button>Wrong Email Id </div>";
    echo "<script>location='forgot_pwd.php?$message';</script>";
  }
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
</head>

<body class="loginbody">

  <div class="loginwrapper">
    <div class="loginwrap zindex100 animate2 bounceInDown">
      <h1 class="logintitle"><span class=""></span> FORGOT PASSWORD <span class="subtitle"></span></h1>
      <div class="loginwrapperinner">
        <?php if (!empty($message)) {
          echo $message;
        } ?>
        <form action="" method="post">
          <center>
            <!-- <p class="animate4 bounceInDown">
              	<img src="logo.png">
              </p> -->
          </center>
          <p class="animate4 bounceIn"><input type="text" id="email" name="email" placeholder="Email Or Contact" autocomplete="off" autofocus /></p>
          <p class="animate5 bounceIn">


          <h3 align="center" style="color:#F6F8F6"><strong></strong></h3>
          </p>

          <input type="submit" name="submit" onClick="return checkinputmaster('email')" class="btn btn-default btn-block" value="SEND">
          </p>

        </form>
      </div><!--loginwrapperinner-->
    </div>
    <div class="loginshadow animate3 fadeInUp"></div>
  </div><!--loginwrapper-->


</body>

</html>