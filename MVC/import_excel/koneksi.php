<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'kbiwh00';

$connect = mysqli_connect($host,$user,$pass);
mysqli_select_db($connect,$db);
?>
