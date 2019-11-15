<?php
require_once("../model/authorization_class.php");

$Authorization = new Authorization();

$activity = $_GET['activity'];

if($activity=="login")
{
	$loginName=$_POST['userName'];
	$loginPass=$_POST['userPass'];
	$userType=$_POST['a'];
	
	$Access=$Authorization->AuthenticateLogin($loginName,$loginPass, $userType);	
}

if($activity=="forgot")
{
	$email=$_POST['email'];
	
	//$Access=$Authorization->forgotPassword($email);	
	echo "Emel Sudah Dihantar";
}

if($activity=="reset")
{
	$password=$_POST['pass'];
	$password2=$_POST['repass'];
	
	//$Access=$Authorization->AuthenticateLogin($password,$password2);	
	echo "Password Telah Berjaya Diubah";
}
?>

