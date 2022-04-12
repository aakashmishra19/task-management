<?php
include_once('includes/dbconnect.php');
include_once('includes/_commonFun.php');

if(isset($_POST['Login']))
{
    if (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) 
    {
         echo "<script>alert('Wrong Email & Password!')</script>";
    }elseif (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#",$_POST['Password'])) 
    {
         echo "<script>alert('Wrong Email & Password!')</script>";
    }else{
        $Login_Email= $_POST['Email'];
        $Login_Password=$_POST['Password'];

        if(empty($Login_Email) OR empty($Login_Password))
        {
          echo '<script type="text/javascript">alert("Empty Fields!")</script>';
        }
        else
        {
            if(!empty($Login_Email))
            {
                $Login_Password_SHA = hash('sha256', $Login_Password); 
                $sql = "SELECT * FROM users WHERE BINARY UserEmail = '$Login_Email' AND BINARY UserPassword = '$Login_Password_SHA'";
                $result = $conn->query($sql);
                $count = mysqli_num_rows($result);
                if ($count == 1)
                {
                    $row = $result->fetch_assoc();
                    $_SESSION['UserID'] = $row["UserID"];   
                    $_SESSION['UserEmail'] = $row["UserEmail"];                               
                    $_SESSION['LoginCheck'] = "Login_Successfully";


                    $LoginHistory = $row["LoginHistory"]; 
                    if (empty($LoginHistory)) {
                        $LoginHistoryArr['LoginHistory'][0]['LoginBy'] = $row["UserID"];
                        $LoginHistoryArr['LoginHistory'][0]['DateTime'] = $timestamp;
                        $LoginHistoryJSON = json_encode($LoginHistoryArr);
                    	
                    }else{
                    	$LoginHistoryArr = json_decode($LoginHistory, true);
	                    $countLH = count($LoginHistoryArr['LoginHistory']);
	                    $LoginHistoryArr['LoginHistory'][$countLH]['LoginBy'] = $row["UserID"];
	                    $LoginHistoryArr['LoginHistory'][$countLH]['DateTime'] = $timestamp;

                        $LoginHistoryJSON = json_encode($LoginHistoryArr);
                    }

                    $sqlIAUM001 = "UPDATE users SET LoginHistory='$LoginHistoryJSON' WHERE BINARY UserEmail = '$Login_Email' AND BINARY UserPassword = '$Login_Password_SHA'";
                    if ($conn->query($sqlIAUM001) === true) {
        				header('location: ./app/dashboard.php');
                    } else {
                		echo "<script>alert('Something Went Wrong! Please Try again Later')</script>";
                    }
                }else{
                  echo "<script>alert('Wrong Email & Password!')</script>";
                }
            }else
            {
                echo "<script>alert('Invalid Inputs !')</script>";
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
					  		<div class="col-md-6 p-5">
					  			<h5 class="card-title  mt-5 text-center">Task Manager Login</h5>
					  			<form method="post" class="mt-5 p-3">
								  <div class="mb-3">
								    <label for="exampleInputEmail1" class="form-label">Email address</label>
								    <input type="email" name="Email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
								  </div>
								  <div class="mb-3">
								    <label for="exampleInputPassword1" class="form-label">Password</label>
								    <input type="password" name="Password" class="form-control" id="exampleInputPassword1">
								  </div>
								  <button type="submit" name="Login" value="Login" class="btn btn-primary w-100">Submit</button>
								</form>
								<div class="col-md-12 p-3 text-center">
									<a href="register.php">Don't have an Account</a>
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