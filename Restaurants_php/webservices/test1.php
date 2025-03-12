<?php
$data = "123_String";    
$whatIWant = substr($data, strpos($data, "123_") + 4);    
echo $whatIWant;
?>