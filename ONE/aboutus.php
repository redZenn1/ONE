<html>
<title>ONE</title>
<link rel="shortcut icon" href="images/eureka.ico" >
<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

require_once('model/about_class.php');
require_once('model/database_connection.php');
require_once('model/profile_class.php');

$Profile = new Profile();
$About = new About();

$userId = $_SESSION['userId'];
$userRole = $_SESSION['userRole'];

$highCommitte = $About->getAllHigh();
?>

<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.w3-sidebar a {font-family: "Roboto", sans-serif}
body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}

html {
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: inherit;
}

.column {
  float: left;
  width: 33.3%;
  margin-bottom: 16px;
  padding: 0 8px;
}

@media screen and (max-width: 650px) {
  .column {
    width: 100%;
    display: block;
  }
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}

.container {
  padding: 0 16px;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}

.title {
  color: grey;
}

.button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
}

.button:hover {
  background-color: #555;
}

.img-circle {
    border-radius: 50%;
}

</style>
<body class="w3-content" style="max-width:1300px">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-light-gray w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
    <h3 class="w3-wide"><b>ONE</b></h3>
    <br>
	<?php
	if ($_SESSION['userId']=="" || $_SESSION['userName']=="" || $_SESSION['userFullname']=="")
	{	
	?>
    	<img class="img-circle" src="images/logoWA.jpg" width="120" height="120">
    <?php
	}
	else
	{ 
		if($userRole==2)
			$Profile->displayPP($userId); 
		else
			$Profile->displayPA($userId);	
	}
	?>
  </div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
    <?php
	if ($_SESSION['userId']=="" || $_SESSION['userName']=="" || $_SESSION['userFullname']=="")
	{	
	?>
    	<a href="home.php" class="w3-bar-item w3-button"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
        <a href="view/event.php" class="w3-bar-item w3-button"><i class="fa fa-calendar" aria-hidden="true"></i> Event</a>
    	<a href="view/contactUs.php" class="w3-bar-item w3-button"><i class="fa fa-fw fa-envelope"></i> Contact</a> 
    	<a href="aboutUs.php" class="w3-bar-item w3-button"><i class="fa fa-users" aria-hidden="true"></i>
 About Us</a>
    <?php
	}
	else
	{
	?>
    	<a href="home.php" class="w3-bar-item w3-button"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
    	<a href="view/profile.php?id=<?php echo $_SESSION['userId']; ?>&type=<?php echo $_SESSION['userRole']; ?>" class="w3-bar-item w3-button"><i class="fa fa-user-circle" aria-hidden="true"></i> Profile</a>
        <a href="view/event.php" class="w3-bar-item w3-button"><i class="fa fa-calendar" aria-hidden="true"></i> Event</a>
    	<a href="view/contactUs.php" class="w3-bar-item w3-button"><i class="fa fa-fw fa-envelope"></i> Contact</a> 
    	<a href="aboutUs.php" class="w3-bar-item w3-button"><i class="fa fa-users" aria-hidden="true"></i> About Us </a>
    	<a href="logout.php" class="w3-bar-item w3-button"><i style="font-size:24px" class="fa">&#xf08b;</i> Log out</a>
     <?php
	}
	?>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
  <div class="w3-bar-item w3-padding-24 w3-wide">One</div>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px">

  <!-- Push down content on small screens -->
  <div class="w3-hide-large" style="margin-top:83px"></div>
  
  <!-- Top header -->
  <header class="w3-container w3-xlarge">
    <p class="w3-left">About Us</p>
    <?php
	if ($_SESSION['userId']=="" || $_SESSION['userName']=="" || $_SESSION['userFullname']=="")
	{	
	?>
    	<p class="w3-right"><a href="login.php" class="w3-bar-item w3-button w3-light-grey">Login</a></p>
    <?php
	}
	else
	{
	?>
    	<p class="w3-right">Hello, <?php echo $_SESSION['userFullname']; ?>!</p>
        <?php
	}
	?>  </header>
    
  <?php
	$i = 1;
	if($highCommitte)
	{	
	 	foreach($highCommitte as $row)
	  	{	
	  		$adminId = $row['adminId'];
			$adminName = $row['adminName'];
	  		$adminPhoto = $row['adminPhoto'];
	 		$adminFullname = $row['adminFullname'];
			$adminEmail = $row['adminEmail'];
			$adminPhone = $row['adminPhone'];
			$adminAddress = $row['adminAddress'];
			$title = $row['title'];
			?>
            <div class="row">
 				<div class="column">
   					<div class="card">
      					<img src="images/nopic.png" alt="Jane" style="width:100%">
      						<div class="container">
        						<h2><?php echo $adminFullname; ?></h2>
        						<p class="title"><?php echo $title; ?></p>
      						</div>
    				</div>
                </div>
            <?php
			if($i%3==0)
	   		{
				?>
                </div>
                <?php
			}
		}
	}
	?>

<script>
// Accordion 
function myAccFunc() {
  var x = document.getElementById("demoAcc");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}

// Click on the "Jeans" link on page load to open the accordion for demo purposes
document.getElementById("myBtn").click();


// Open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}
</script>

</body>
</html>
