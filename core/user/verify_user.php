<?php
require_once("../init.php");
$email=$_GET['email'];
$verify_string=$_GET['verify_string'];
$query=mysqli_query($con,"UPDATE user SET status=1 WHERE email='$email' AND verify_string='$verify_string' AND status=0;");
if($query){
		echo "Congratulations,You have succefully activated your account,login to proffersys!";
		header("Location:login.php");
	}
	else{
		echo "sorry you could not be verified ,try again!";
	}
//echo "account activated!";
?>
