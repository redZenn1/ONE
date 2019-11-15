<?php
require_once('database_connection.php');
require_once('crypto_class.php');
require_once('datalib.php');

$Data = new Datalib();
$Crypto = new Crypto();

class Authorization
{
	public function __Construct()
	{		}
	
	public function AuthenticateLogin($loginName,$loginPass, $userType)
	{
		$Con = mysqli_connect("localhost", "root", "", "one");
		$Data = new Datalib();
		$Crypto = new Crypto();
		
		$checkAccUser=$this->checkExistAccount_user($loginName);//Check acc user
		$checkAccAdmin=$this->checkExistAccount_admin($loginName);//Check acc admin
		$checkAccCoach=$this->checkExistAccount_coach($loginName);//Check acc admin
		$loginName=mysqli_real_escape_string($Con, $loginName);
		$loginPass=mysqli_real_escape_string($Con, $loginPass);
		
		if(($checkAccUser==false) && ($checkAccAdmin==false) && ($checkAccCoach==false))
		{
			echo "<script language='JavaScript'> alert('Anda Bukan Ahli. Sila Daftar Dahulu.'); window.location.href='../login.php?val=true'; </script>";
		}
			
		if($userType=="1")
		{
			$encryptPass=$Crypto->combination_encrypt($loginPass);
			$sql = "SELECT * 
					FROM administrator
					WHERE adminName='$loginName' 
					AND adminPassword='$encryptPass'";
					
			$result=mysqli_query($Con, $sql) or die ('Query Failed' . mysqli_error($Con));
			$row=mysqli_fetch_array($result, MYSQLI_BOTH);
				
			if (mysqli_num_rows($result)==1) 
			{
				session_start();	
				$_SESSION['auth']=true;					
				$_SESSION['userRole']=$row['userTypeID'];
				$_SESSION['userRoleDesc']=$row['userTypeDesc'];
				$_SESSION['userId']=$row['adminID'];
				$_SESSION['userName']=$row['adminName'];
				$_SESSION['userFullname']=$row['adminFullname'];
				$_SESSION['userIC']=$row['adminIC'];
				$_SESSION['userEmail']=$row['adminEmail'];	
				$_SESSION['userPhone']=$row['adminPhone'];	
				$_SESSION['userAddress']=$row['adminAddress'];	
				$_SESSION['userPhoto']=$row['userPhoto'];	
				$_SESSION['userPhotoName']=$row['userPhotoName'];	
					
				$result=mysqli_query($Con, $sql) or die ('Query Failed' . mysqli_error($Con));
				
				if($result)
				{
					echo "<script language='JavaScript'>alert('Anda Berjaya Masuk!');window.location.href='../home.php?val=true';</script>";	
				}
			}		
			else 
			{	
				echo "<script language='JavaScript'>alert('Anda Gagal. Sila Cuba Lagi.');window.location.href='../login.php?val=true';</script>";	
			}
		}
		
		else  if($userType=="2")
		{
			$encryptPass=$Crypto->combination_encrypt($loginPass);
			$sql = "SELECT * FROM participant WHERE userName='$loginName' AND userPassword='$encryptPass'";
			$result=mysqli_query($Con, $sql) or die ('Query Failed' . mysqli_error($Con));
			$row=mysqli_fetch_array($result, MYSQLI_BOTH);
				
			if (mysqli_num_rows($result)==1) 
			{
				session_start();	
				$_SESSION['auth']=true;					
				$_SESSION['userRole']=$row['userTypeID'];
				$_SESSION['userRoleDesc']=$row['userTypeDesc'];
				$_SESSION['userId']=$row['userID'];
				$_SESSION['userName']=$row['userName'];
				$_SESSION['userFullname']=$row['userFullname'];
				$_SESSION['userIC']=$row['userIC'];
				$_SESSION['userEmail']=$row['userEmail'];	
				$_SESSION['userPhone']=$row['userPhone'];	
				$_SESSION['userAddress']=$row['userAddress'];
				$_SESSION['userPhoto']=$row['userPhoto'];	
				$_SESSION['userPhotoName']=$row['userPhotoName'];		
					
				
				$sql2 = "UPDATE participant SET userStatus='ACTIVE' WHERE username='$loginName' AND userPass='$encryptPass'";
				$result=mysqli_query($Con, $sql) or die ('Query Failed' . mysqli_error($Con));
				
				if($result)
				{
					echo "<script language='JavaScript'>alert('Anda Berjaya Masuk! Status Anda Telah Dikemaskini.');window.location.href='../home.php?val=true';</script>";		
				}
				
			}
			else 
			{	
				echo "<script language='JavaScript'>alert('Anda Gagal. Sila Cuba Lagi.');window.location.href='../login.php?val=true';</script>";	
			}
		}
		
		else if($userType=="3")
		{
			$encryptPass=$Crypto->combination_encrypt($loginPass);
			$sql = "SELECT * 
					FROM coach
					WHERE coachName='$loginName' 
					AND coachPassword='$encryptPass'";
					
			$result=mysqli_query($Con, $sql) or die ('Query Failed' . mysqli_error($Con));
			$row=mysqli_fetch_array($result, MYSQLI_BOTH);
				
			if (mysqli_num_rows($result)==1) 
			{
				session_start();	
				$_SESSION['auth']=true;					
				$_SESSION['userRole']=$row['userTypeID'];
				$_SESSION['userRoleDesc']=$row['userTypeDesc'];
				$_SESSION['userId']=$row['coachID'];
				$_SESSION['userName']=$row['coachName'];
				$_SESSION['userFullname']=$row['coachFullname'];
				$_SESSION['userIC']=$row['coachIC'];
				$_SESSION['userEmail']=$row['coachEmail'];	
				$_SESSION['userPhone']=$row['coachPhone'];	
				$_SESSION['userAddress']=$row['coachAddress'];	
				$_SESSION['userPhoto']=$row['userPhoto'];	
				$_SESSION['userPhotoName']=$row['userPhotoName'];	
					
				$result=mysqli_query($Con, $sql) or die ('Query Failed' . mysqli_error($Con));
				
				if($result)
				{
					echo "<script language='JavaScript'>alert('Anda Berjaya Masuk!');window.location.href='../home.php?val=true';</script>";	
				}
			}		
			else 
			{	
				echo "<script language='JavaScript'>alert('Anda Gagal. Sila Cuba Lagi.');window.location.href='../login.php?val=true';</script>";	
			}
		}
	}
	
	
	public function AuthenticateSignup($loginName,$loginPass, $fullName, $email, $address, $phoneNo, $image, $name)
	{
		$Con = mysqli_connect("localhost", "root", "", "one");
		$Data = new Datalib();
		$Crypto = new Crypto();

		$checkAccUser=$this->checkExistAccount_user($loginName);	
		$checkAccCoach=$this->checkExistAccount_coach($loginName);
		$loginName=mysqli_real_escape_string($Con, $loginName);
		$loginPass=mysqli_real_escape_string($Con, $loginPass);
			
		if (($checkAccUser==true) && ($checkAccCoach==true))//Acc already exist
		{	
			echo "<script LANGUAGE='JavaScript' type='text/javascript'>window.alert('Anda Sudah Menjadi Ahli!');
		window.location.href='../login.php';</script>"; 
		}
		if ($checkAccUser==false)//Acc Participant not exist yet
		{
			$encryptPass=$Crypto->combination_encrypt($loginPass);
			$sql = "INSERT INTO participant(userName, userPassword, userFullname, userEmail, userPhone, userAddress, userPhotoName, userPhoto, userStatus, userTypeID, userTypeDesc)
					VALUES('".$loginName."','".$encryptPass."', '".$fullName."', '".$email."', '".$phoneNo."',  '".$address."', '".$name."',  '".$image."', 'ACTIVE', '2', 'Participant')";
			/**$sql = "INSERT INTO admin(adminName, adminPass, adminFullname, adminEmail, adminPhone, adminAddress, userPhotoName, userPhoto, userStatus, userTypeID, userTypeDesc)
					VALUES('".$loginName."','".$encryptPass."', '".$fullName."', '".$email."', '".$phoneNo."',  '".$address."', '".$name."',  '".$image."', 'ACTIVE', '1', 'Administrator')";*/
			$result_insert=$Data->int_db_insertion($sql);
			return $result_insert;
		}
		if ($checkAccCoach==false)//Acc Coach not exist yet
		{
			$encryptPass=$Crypto->combination_encrypt($loginPass);
			$sql = "INSERT INTO coach(coachName, coachPassword, coachFullname, coachEmail, coachPhone, coacAddress, userPhotoName, userPhoto, userTypeID, userTypeDesc)
					VALUES('".$loginName."','".$encryptPass."', '".$fullName."', '".$email."', '".$phoneNo."',  '".$address."', '".$name."',  '".$image."',  '3', 'Coach')";
			/**$sql = "INSERT INTO admin(adminName, adminPass, adminFullname, adminEmail, adminPhone, adminAddress, userPhotoName, userPhoto, userStatus, userTypeID, userTypeDesc)
					VALUES('".$loginName."','".$encryptPass."', '".$fullName."', '".$email."', '".$phoneNo."',  '".$address."', '".$name."',  '".$image."', 'ACTIVE', '1', 'Administrator')";*/
			$result_insert=$Data->int_db_insertion($sql);
			return $result_insert;
		}
		
	}
	
	private function checkExistAccount_user($loginName)
	{	
		$Con = mysqli_connect("localhost", "root", "", "one");
		
		$sql="SELECT userID FROM participant WHERE userName='$loginName' ";		
		$result=mysqli_query($Con, $sql) or die ('Query Failed checkExistAccount_user' . mysqli_error($Con));
		$row=mysqli_fetch_array($result, MYSQLI_BOTH);
		if (mysqli_num_rows($result)==1) 
		{
			return true;
		}
 
 		else 
		{
			return false;
		}
	}	
	
	private function checkExistAccount_admin($loginName)
	{	
		$Con = mysqli_connect("localhost", "root", "", "one");
		
		$sql="SELECT adminID FROM administrator WHERE adminName='$loginName' ";		
		$result=mysqli_query($Con, $sql) or die ('Query Failed checkExistAccount_admin' . mysqli_error($Con));
		$row=mysqli_fetch_array($result, MYSQLI_BOTH);
		if (mysqli_num_rows($result)==1) 
		{
			return true;
		}
 
 		else 
		{
			return false;
		}
	}	
	
	private function checkExistAccount_coach($loginName)
	{	
		$Con = mysqli_connect("localhost", "root", "", "one");
		
		$sql="SELECT coachID FROM coach WHERE coachName='$loginName' ";		
		$result=mysqli_query($Con, $sql) or die ('Query Failed checkExistAccount_admin' . mysqli_error($Con));
		$row=mysqli_fetch_array($result, MYSQLI_BOTH);
		if (mysqli_num_rows($result)==1) 
		{
			return true;
		}
 
 		else 
		{
			return false;
		}
	}	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
