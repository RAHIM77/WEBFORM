<?php
require 'dbconfig/config.php';
if(isset($_POST) & !empty($_POST)){
	$username = mysqli_real_escape_string($con, $_POST['username']);
	$sql = "SELECT * FROM userinfo WHERE username = '$username'";
	$res = mysqli_query($con,$sql);
	$count = mysqli_num_rows($res);
	if($count == 1){
		echo "Send email to user with password";
	}else{
		echo "User name does not exist in database";
	}
}
$password = rand(999, 99999);
$password_hash = md5($pass);
$r = mysqli_fetch_assoc($res);
$password = $r['password'];
$to = $r['email'];
$subject = "Your Recovered Password";

$message = "Please use this password to login " . $password;
$headers = "From : rahimshaikh7000@gmmail.com";
if(mail($to, $subject, $message, $headers)){
	echo "Your Password has been sent to your email id";
}else{
	echo "Failed to Recover your password, try again";
}
$password = rand(999, 99999);
$password_hash = md5($pass);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Password recovery page</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color:#bdc3c7">
<div id="main-wrapper">
<form action="passrecover.php" method="post">
<p>Email Address: <input type="text" name="remail" size="50" maxlength="255" class="inputvalues">
<input type="submit" name="submit" value="Get New Password"></p>
</form>
</div>
</body>
</html>
