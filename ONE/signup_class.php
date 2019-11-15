Skip to content
Search or jump to…

Pull requests
Issues
Marketplace
Explore
 
@AtiqahIsza 
Learn Git and GitHub without any code!
Using the Hello World guide, you’ll start a branch, write comments, and open a pull request.


1
00redZenn1/one-updated
 Code Issues 0 Pull requests 0 Projects 0 Wiki Security Insights
one-updated/signup_class.php
@redZenn1 redZenn1 Add files via upload
c370e59 1 hour ago
33 lines (28 sloc)  1.05 KB
  
<?php
require_once("model/authorization_class.php");
require_once('model/database_connection.php');
require_once('model/crypto_class.php');
require_once('model/datalib.php');
$Data = new Datalib();
$Crypto = new Crypto();
$Authorization = new Authorization();
$fullName=$_POST["fname"];
$loginName=$_POST['uname'];
$loginPass=$_POST['psw'];
$email=$_POST["email"];	
$phoneNo=$_POST["phoneno"];	
$address=$_POST["address"];		
$name=addslashes($_FILES['image']['name']);
$image=base64_encode(file_get_contents(addslashes($_FILES['image']['tmp_name'])));
$Access=$Authorization->AuthenticateSignup($loginName,$loginPass, $fullName, $email, $address, $phoneNo, $image, $name);
if($Access==true)
{
	echo "<script LANGUAGE='JavaScript' type='text/javascript'>window.alert('Pendaftaran Akaun Anda Berjaya!');
	window.location.href='login.php?val=true';</script>";  
}
else
{
	echo "<script LANGUAGE='JavaScript' type='text/javascript'>window.alert('Pendaftaran Akaun Anda Tidak Berjaya! Sila Cuba Lagi');
	window.location.href='login.php?val=true';</script>"; 	
}
?>
© 2019 GitHub, Inc.
Terms
Privacy
Security
Status
Help
Contact GitHub
Pricing
API
Training
Blog
About
