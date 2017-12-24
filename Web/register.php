<?php
	require 'dbconfig/config.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Registration Page</title>
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript">

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("imglink").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

</script>
</head>
<body style="background-color:#bdc3c7">
<div id="main-wrapper">
	<form class="myform" action="register.php" method="post"  enctype="multipart/form-data" >
			<center>
			<h2>Registration Form</h2>
			<img id="uploadPreview" src="imgs/avatar.png" class="avatar"/><br>
	<input type="file" id="imglink" name="imagelink" accept=".jpg,.jpeg,.png" onchange="PreviewImage();"/>
		   </center>

			<label><b>Full Name:</b></label><br>
			<input name="fullname" type="text" class="inputvalues" placeholder="Type your Full Name" required/><br>

			<label><b>Email:</b></label><br>
			<input name="email" type="text" class="inputvalues" placeholder="Type your email" required/><br>

			<label><b>Age:</b></label><br>
			<input name="Age" type="text" class="inputvalues" placeholder="Type your Age" required/><br>

			<label><b>Gender:</b></label><br>
			<input type="radio" name="Gender" value="male" class="radio_btn" checked required>Male
			<input type="radio" name="Gender" value="female" class="radio_btn" required>Female<br>

			<label><b>Dob:</b></label><br>
			<input name="Dob" type="date" class="inputvalues" placeholder="yyyy-mm-dd" required /><br>

			<label><b>Username:</b></label><br>
			<input name="username" type="text" class="inputvalues" placeholder="Type your username" required/><br>
			<label><b>Password:</b></label><br>
			<input name="password" type="password" class="inputvalues" placeholder="Your password" required/><br>
			<label><b>Confirm Password:</b></label><br>
			<input name="cpassword" type="password" class="inputvalues" placeholder="Confirm password" required/><br>
			<input name="submit_btn" type="submit" id="signup_btn" value="Sign Up"/><br>
			<a href="index.php"><input type="button" id="back_btn" value="Back"/></a>
		</form>
		
		<?php
			if(isset($_POST['submit_btn']))
			{
				
				$fullname =$_POST['fullname'];
				$email =$_POST['email'];
				$Age = $_POST['Age'];
				$Gender = $_POST['Gender'];

				/*$Dob = $_POST['Dob'];
                $Dob = strtotime($Dob);
                $Dob = date_create_from_format('d/m/Y', $Dob);*/
                $Dob = $_POST['Dob'];
				$Dob = str_replace("/", "-", $Dob);
				$Dob = strtotime($Dob);
				$username = $_POST['username'];
				$password = $_POST['password'];
				$cpassword = $_POST['cpassword'];
				$img_name = $_FILES['imagelink']['name'];
				$img_size =$_FILES['imagelink']['size'];
			    $img_tmp =$_FILES['imagelink']['tmp_name'];
				
				$directory = 'uploads/';
				$target_file = $directory.$img_name;
				if($password==$cpassword)
				{
					
					$query= "select * from userinfo WHERE username='$username'";
					$query_run = mysqli_query($con,$query);
					
					if(mysqli_num_rows($query_run)>0)
					{
						// there is already a user with the same username
						echo '<script type="text/javascript"> alert("User already exists.. try another username") </script>';
					}
						else if(file_exists($target_file))
						{
							echo '<script type="text/javascript"> alert("Image file already exists.. Try another image file") </script>';
						}
					
						else if($img_size>2097152)
						{
							echo '<script type="text/javascript"> alert("Image file size larger than 2 MB.. Try another image file") </script>';
						}

					
					
					else
					{
					 	move_uploaded_file($img_tmp,$target_file); 	
		     $query= "insert into userinfo values('','$fullname','$email','$Age','$Gender','$Dob','$username','$password','$target_file')";
						$query_run = mysqli_query($con,$query);
						
						if($query_run)
						{
							echo '<script type="text/javascript"> alert("User Registered.. Go to login page to login") </script>';
						}
						else
						{
							echo '<script type="text/javascript"> alert("Error!") </script>';
						}
					}	
					
					
				}
				else
				{
					echo '<script type="text/javascript"> alert("Password and confirm password does not match!")</script>';	
				}
				
				
				
				
			}
		?>
	</div>
</body>
</html>