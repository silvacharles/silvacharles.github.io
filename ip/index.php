<?php
if (isset($HTTP_X_FORWARDED_FOR)) {
$IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else{
$IP= $_SERVER['REMOTE_ADDR'];
}
echo $IP ."\n";
?>
