<?php
include_once('includes/dbconnect.php');
include_once('includes/_commonFun.php');

if(isset($_POST['Register']))
{
    if (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) 
    {
         echo "<script>alert('Wrong Email')</script>";
    }elseif (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#",$_POST['Password'])) 
    {
         echo "<script>alert('Wrong Password!')</script>";
    }elseif (!preg_match("/^[a-zA-Z. ]{4,20}$/", $_POST['FullName'])) 
    {
         echo "<script>alert('Wrong Full Name!')</script>";
    }else{
        $Email= $conn->real_escape_string($_POST['Email']);
        $Password= $conn->real_escape_string($_POST['Password']);
        $FullName= $conn->real_escape_string($_POST['FullName']);

        if(empty($Email) OR empty($Password) OR empty($FullName))
        {
          echo '<script type="text/javascript">alert("Empty Fields!")</script>';
        }
        else
        {
            $sql = "SELECT UserEmail FROM users WHERE UserEmail = '$Email'";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
	            $UserID = randome10();
	            $sql = "SELECT UserID FROM users WHERE UserID = '$UserID'";
	            $result = $conn->query($sql);
	            while ($result->num_rows > 0) {
	                $UserID = randome15();
	                $sql = "SELECT UserID FROM users WHERE UserID = '$UserID'";
	                $result = $conn->query($sql);
	            }
	            $Password = hash('sha256', $_POST['Password']);

	            $sql = "INSERT INTO users  (UserID, UserFullName, UserEmail, UserPassword, LoginHistory)  VALUES('$UserID','$FullName','$Email','$Password','')";
	            if ($conn->query($sql) === true) {
	                echo "<script>alert('Registered Successfully! Please Login')</script>";
	            } else {
	                echo "<script>alert('Something Went Wrong! Please Try again Later')</script>";
	            }
	        }else{
	            echo "<script>alert('Email id Already Exists')</script>";
	        }
        }
    }

}

if(loggedin())
{
    header('location: ./app/dashboard.php');
}else{

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login - Task Management</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<section class="Login-Section">
		<div class="container">
			<div class="row">
				<div class="col-md-8 m-auto">
					<div class="card">
					  <div class="card-body">
					  	<div class="row">
					  		<div class="col-md-6 p-5 pt-3">
					  			<h5 class="card-title  mt-5 text-center">Task Manager Register</h5>
					  			<form method="post" class="mt-5 p-3">
								  <div class="mb-3">
								    <label for="exampleInputFullName" class="form-label">Full Name</label>
								    <input type="text" name="FullName" class="form-control" id="exampleInputFullName" aria-describedby="emailHelp">
								  </div>
								  <div class="mb-3">
								    <label for="exampleInputEmail1" class="form-label">Email address</label>
								    <input type="email" name="Email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
								  </div>
								  <div class="mb-3">
								    <label for="exampleInputPassword1" class="form-label">Password</label>
								    <input type="password" name="Password" class="form-control" id="exampleInputPassword1">
								  </div>
								  <button type="submit" name="Register" value="Register" class="btn btn-primary w-100">Register</button>
								</form>
								<div class="col-md-12 p-3 text-center">
									<a href="index.php">Have an Account</a>
								</div>

					  		</div>
					  		<div class="col-md-6 text-center">
					  			<img src="./assets/images/task-login.svg" class="img-fluid mt-5 mb-5">
					  		</div>
					  	</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</section>

</body>
</html>

<?php 
}
?>