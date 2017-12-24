<?php
require 'dbconfig/config.php';

//This code runs if the form has been submitted
if (isset($_POST['submit']))
{

// check for valid email address
$email = $_POST['remail'];
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
     $error[] = 'Please enter a valid email address';
}

// checks if the username is in use
$check = mysqli_query($con,"SELECT Email FROM userinfo WHERE Email = '$email'")or die(mysql_error());
$check2 = mysqli_num_rows($check);

//if the name exists it gives an error
if ($check2 == 0) {
$error[] = 'Sorry, we cannot find your account details please try another email address.';
}

// if no errors then carry on
if (!$error) {

$query = mysql_query("SELECT username FROM userinfo WHERE Email = '$email'")or die (mysql_error());
$r = mysql_fetch_object($query);

//create a new random password

$password = substr(md5(uniqid(rand(),1)),3,10);
$pass = md5($password); //encrypted version for database entry

//send email
$to = "$email";
$subject = "Account Details Recovery";
$body = "Hi $r->username, nn you or someone else have requested your account details. nn Here is your account information please keep this as you may need this at a later stage. nnYour username is $r->username nn your password is $password nn Your password has been reset please login and change your password to something more rememberable.nn Regards Site Admin";
$additionalheaders = "From: <rahimshaikh7000@gmail.com>rn";
$additionalheaders .= "Reply-To: noprely@domain.com";
mail($to, $subject, $body, $additionalheaders);

//update database
$sql = mysqli_query($con,"UPDATE userinfo SET password='$pass' WHERE Email = '$email'")or die (mysql_error());
$rsent = true;


}// close errors


//show any errors
if (!empty($error))
{
        $i = 0;
        while ($i < count($error)){
        echo "<div class='msg-error'>".$error[$i]."</div>";
        $i ++;}
}// close if empty errors

if ($rsent == true){
    echo "<p>You have been sent an email with your account details to $email</p>n";
    } else {
    echo "<p>Please enter your e-mail address. You will receive a new password via e-mail.</p>n";
    }

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
