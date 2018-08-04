<?php 
$host = 'localhost';
$user = 'root';
$password = 'daque2018!#!$';

$con = mysqli_connect($host,$user,$password);
if (!$con)
{
    die('Could not connect: ' . mysqli_error());
}else{
    mysqli_select_db($con,'sms');
}

?>