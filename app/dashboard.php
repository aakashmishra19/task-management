<?php
include_once('../includes/dbconnect.php');
include_once('../includes/_commonFun.php');


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dashboard</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
	<header>
		<div class="container-fluid">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <a class="navbar-brand" href="dashboard.php">Task Management</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse ms-5" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item active">
		        <a class="nav-link" href="dashboard.php">Dashboard</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="task.php">Task</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="logout.php">Logout</a>
		      </li>
		    </ul>
		  </div>
		</nav>
		</div>
	</header>
	<section class="dashboard">
		<div class="container mt-5">
			<div class="row">
				<?php
				$sql = "SELECT * FROM task WHERE UserID = '$UserID' && Status = 'Completed'";
				$result = $conn->query($sql);
				$CompleteCount = $result->num_rows;
				$sql = "SELECT * FROM task WHERE UserID = '$UserID' && Status = 'Uncompleted'";
				$result = $conn->query($sql);
				$UncompletedCount = $result->num_rows;
				$sql = "SELECT * FROM task WHERE UserID = '$UserID' && Status = 'Start'";
				$result = $conn->query($sql);
				$StartCount = $result->num_rows;
				$sql = "SELECT * FROM task WHERE UserID = '$UserID' && Status = 'Inprocess'";
				$result = $conn->query($sql);
				$InprocessCount = $result->num_rows;
					
				?>
				<div class="col-md-3">
					<div class="card">
					  <div class="card-body pt-4 pb-4">
					    <h6 class="card-subtitle mb-2 text-muted">Total Complete Task</h6>
					    <p class="card-text text-success"><?php echo $CompleteCount; ?></p>
					  </div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card">
					  <div class="card-body pt-4 pb-4">
					    <h6 class="card-subtitle mb-2 text-muted">Total Inprocess Task</h6>
					    <p class="card-text text-success"><?php echo $InprocessCount; ?></p>
					  </div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card">
					  <div class="card-body pt-4 pb-4">
					    <h6 class="card-subtitle mb-2 text-muted">Total Start Task</h6>
					    <p class="card-text text-success"><?php echo $StartCount; ?></p>
					  </div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card">
					  <div class="card-body pt-4 pb-4">
					    <h6 class="card-subtitle mb-2 text-muted">Total Uncomplete Task</h6>
					    <p class="card-text text-success"><?php echo $UncompletedCount; ?></p>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>