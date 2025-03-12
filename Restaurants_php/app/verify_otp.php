<?php
// include "action.php"; 
// $pagename = "verify_otp.php";
// $otp_code = $_SESSION['otp_code'];
// $request_id = $_SESSION['request_id'];
// if(isset($_POST['submit']))
// {
//     //print_r($_POST);die;
//     $otp_code1 = $_POST['otp_code'];
//     if($otp_code == $otp_code1)
//     {
//         $where = array('request_id'=>$request_id);
//         $form_data = array('is_verify'=>1,'service_status'=>1);
//         $obj->update_record('request',$where,$form_data);
//         $action = 2;
//         $process="update";
//         setcookie("service_status", "1", time()+2*24*60*60);
//         echo "<script> window.location='success.php';</script>";
//     }
//     else{
//       echo "<script>alert('Enter Correct otp');</script>";
//     }
// }
//print_r($_SESSION);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
  <link rel="stylesheet" href="materialize/css/materialize.min.css">
  <link rel="stylesheet" href="materialize/css/style.css">
  <link rel="stylesheet" href="materialize/css/animate.min.css"/>
  <title>SahiCar.com | OTP Verify</title>
  <style>
  .otp {
    width: 45px !important;
    height: 45px !important;
    box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2) !important;
    background: linear-gradient(to right, #ecf1ed, #fbfffb);
    border: none !important;
    line-height: 45px;
    text-align: center;
    font-size: 24px !important;
    font-weight: 600;
    color: black;
    border-radius: 50% !important;
    margin: 0 2px !important;
  }
  </style>
</head>
<body class="">
  <div class="container animate__animated animate__fadeInRight animate__faster" style="width:100%;height:100vh; background: #FF8008;
background: -webkit-linear-gradient(to top, #FFC837, #FF8008);
background: linear-gradient(to top, #FFC837, #FF8008);">
    <form action="" method="post">
      <div style="padding: 15px;">
        <!-- <div class="row">
          <div class="col s12 m6 offset-m3">
            
          </div>
        </div> -->
        <div class="row">
          <div class="input-field col s12 m6 offset-m3 center">
            <img src="img/otp-sms.svg" alt="OTP-Verify" class="responsive-img">
            <h4><b>Verification</b></h4>
            <p>Please enter your OTP code sent to your <br/> register mobile number.</p><br>
            <div class="digit-group">
              <input type="text" id="digit-1" name="digit-1" data-next="digit-2" class="otp " />
              <input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" class="otp" />
              <input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" class="otp" />
              <input type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" class="otp" />
            </div>
           <p>
           <a href="#" class="red-text">Resend Code</a>
           </p>
          </div>
          <div class="col s12 m6 offset-m3 center">
            <button name="submit" type="submit" class="btn black darken-3 waves-effect next z-depth-3" style="border-radius: 20px;width: 60%;">Verify & Procced</button>
          </div>
        </div>
        
      </div>
    </form>
  </div>
  <script src="materialize/js/jquery.min.js"></script>
  <script src="materialize/js/materialize.min.js"></script>
  <script src="js/sweetalert.min.js"></script>
  <script>
    $(document).ready(function(){
      $('.button').click(function (){
        // swal("Request Sent", "Your request add in our service successfully", "success");
        var otp_code = $('#otp_code').val();
        if(otp_code == "")
        {
          window.location="verify_otp.php";
        }
        else{
          
        }
        
      });
      $('.digit-group').find('input').each(function() {
        $(this).attr('maxlength', 1);
        $(this).on('keyup', function(e) {
          var parent = $($(this).parent());
          
          if(e.keyCode === 8 || e.keyCode === 37) {
            var prev = parent.find('input#' + $(this).data('previous'));
            
            if(prev.length) {
              $(prev).select();
            }
          } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
            var next = parent.find('input#' + $(this).data('next'));
            
            if(next.length) {
              $(next).select();
            } else {
              if(parent.data('autosubmit')) {
                parent.submit();
              }
            }
          }
        });
      });
    });
    
  </script>
</body>
</html>