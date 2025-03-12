<?php include("../adminsession.php");
$selectcompany = trim(addslashes($_REQUEST['selectcompany']));
//print_r($_REQUEST);die;
$_SESSION['companyid'] = $selectcompany;

?>