<?php
include("../adminsession.php");
$oldpass=$_SERVER['QUERY_STRING'];
$where = array('password'=>$oldpass);
$cnt = $obj->count_method('user',$where);

//echo $sql;
$idname = "";

if($cnt!=0)
$idname ="Old password is correct";
else
$idname = "Old password is wrong";

//echo $idname;
?>
