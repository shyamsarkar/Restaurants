<?php
include("../adminsession.php");
//mysqli_query($con,"insert into loginlogoutreport set userid ='$loginid',usertype = '$usertype',process = 'Logout',loginlogouttime = now(),createdate = now(),ipaddress = '$ipaddress'");
session_destroy();

echo "<script>location='../index.php?msg=logout' </script>" ;

?>