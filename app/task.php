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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
	<section>
		<div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Task List</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-12 text-end">
                                        <div>
                                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#Add-Task"><i class="ri-add-line align-bottom me-1"></i> Add</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="table-responsive mt-3 mb-1">
                                    <table id="task-list-view" class="table  table-bordered dt-responsive nowrap display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Task ID</th>
                                                <th>Task Name</th>
                                                <th>Status</th> 
                                                <th>Create Date</th> 
                                                <th>Action</th> 
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div><!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end col -->
            </div>
		</div>

	</section>

	<!-- The Modal -->
	<div class="modal fade bs-example-modal-xl" id="Add-Task">
	    <div class="modal-dialog modal-dialog-centered  modal-xl">
	        <div class="modal-content">
	            <div class="modal-header bg-light p-3">
	                <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
	                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
	            </div>
	            <form  method="post" id="Add-Task-Form" autocomplete="off">
	                <div class="modal-body">
	                    <input type="hidden" name="action" value="add_task">
	                    <div class="row">
	                        <div class="col-lg-8 col-xl-8 mb-3">
	                            <div class="form-group">
	                                <label for="username">Task Name</label>
	                                <input type="text" class="form-control" name="TaskName" id="TaskName" autocomplete="off">
	                            </div>
	                        </div>
                            <div class="col-lg-4 col-xl-4 mb-3">
                                <div class="form-group">
                                    <label for="username">Select Status</label>
                                    <select class="form-select" name="Status" id="Status_id" autocomplete="off">
                                        <option value="Start">Start</option>  
                                        <option value="Inprocess">Inprocess</option> 
                                        <option value="Uncompleted">Uncompleted</option>  
                                        <option value="Completed">Completed</option>                                    
                                    </select>
                                </div>
                            </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-lg-12 col-xl-12 mb-3">
	                            <div class="form-group">
	                                <label for="username">Task Description</label>
	                                <textarea name="TaskDescription" class="form-control"></textarea>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <div class="hstack gap-2 justify-content-end">
	                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	                        <button class="btn btn-success" name="submit" id="submit" value="submit" type="submit">Add Task</button>
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
	<div class="modal fade bs-example-modal-xl" id="Edit-Task">
	    <div class="modal-dialog modal-dialog-centered  modal-xl">
	        <div class="modal-content">
	            <div class="modal-header bg-light p-3">
	                <h5 class="modal-title" id="exampleModalLabel">Update Task</h5>
	                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
	            </div>
	            <form  method="post" id="Edit-Task-Form" autocomplete="off">
	                <div class="modal-body">
	                    <input type="hidden" name="action" id="action_id" >
	                    <input type="hidden" name="TaskID" id="TaskID_id">
	                    <div class="row">
	                        <div class="col-lg-8 col-xl-8 mb-3">
	                            <div class="form-group">
	                                <label for="username">Task Name</label>
	                                <input type="text" class="form-control" name="TaskName" id="TaskName_id" autocomplete="off">
	                            </div>
	                        </div>
                            <div class="col-lg-4 col-xl-4 mb-3">
                                <div class="form-group">
                                    <label for="username">Select Status</label>
                                    <select class="form-select" name="Status" id="Status_id" autocomplete="off">
                                        <option value="Start">Start</option>   
                                        <option value="Inprocess">Inprocess</option> 
                                        <option value="Uncompleted">Uncompleted</option>  
                                        <option value="Completed">Completed</option>                                    
                                    </select>
                                </div>
                            </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-lg-12 col-xl-12 mb-3">
	                            <div class="form-group">
	                                <label for="username">Task Description</label>
	                                <textarea name="TaskDescription" id="TaskDescription_id" class="form-control"></textarea>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <div class="hstack gap-2 justify-content-end">
	                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	                        <button class="btn btn-success" name="submit" id="submit" value="submit" type="submit">Update Task</button>
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>


	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>


                <script type="text/javascript">

                    var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date( data[4] );
 
        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);
 
$(document).ready(function() {
    // Create date inputs
    minDate = new DateTime($('#min'), {
        format: 'MMMM Do YYYY'
    });
    maxDate = new DateTime($('#max'), {
        format: 'MMMM Do YYYY'
    });
 
    // DataTables initialisation
    var table = $('#example').DataTable();
 
    // Refilter the table
    $('#min, #max').on('change', function () {
        table.draw();
    });
});



                    $(document).ready(function() {
                        var dataTable = $('#task-list-view').DataTable({
                            "rowReorder": {
                                "selector": "td:nth-child(2)"
                            },
                            "responsive": true,
                            "bProcessing": true,
                            "serverSide": true,
                            "ajax": {
                                url: "../api/task_action.php",
                                type: "post",
                                data: {
                                    action: 'fetch_data'
                                },
                                error: function() {
                                    $("#employee_grid_processing").css("display", "none");
                                }
                            }
                        });

                        $('#Add-Task-Form').submit(function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "../api/task_action.php",
                                type: "POST",
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(data) {
                                    if(data == 0){                                      
                                    	alert("Error Notice : Something Went Wrong"); 
                                    }                                    
                                    if(data == 1){    
                                    	alert("Success : Task Add Successfully");        
                                        document.getElementById("Add-Task-Form").reset();
                                        dataTable.ajax.reload();
                                        $('#Add-Task').modal('hide');
                                    }
                                    if(data == 2){   
                                    	alert("Error Notice : Incorrect Data'");  
                                    }
                                    if(data == 9){ 
                                    	alert("Error Notice : Something Went Wrong");    
                                    }
                                    if(data == 11){   
                                    	alert("Error Notice : Task Name Incorrect");  
                                    }                                    
                                    if(data == 12){  
                                    	alert("Error Notice : Task Description Name Incorrect");   
                                    }                                    
                                    if(data == 13){  
                                    	alert("Error Notice : Status Name Incorrect");   
                                    }      

                                }
                            });
                        });


                        $(document).on('click', '.edit_button', function() {
                            var TaskID = $(this).data('id');
                            $.ajax({
                                url: "../api/task_action.php",
                                method: "POST",
                                data: {
                                    TaskID: TaskID,
                                    action: 'fetch_single'
                                },
                                dataType: 'JSON',
                                success: function(data) {
                                    if(data == 0){                                      
                                    	alert("Error Notice : Something Went Wrong"); 
                                    } 
                                    if(data == 9){ 
                                    	alert("Error Notice : Something Went Wrong");    
                                    }
                                    if (data != 0 && data != 9 && data != 31){
                                        $('#action_id').val('edit_task');
                                        $('#TaskID_id').val(data.TaskID);
                                        $('#TaskName_id').val(data.TaskName);
                                        $('#TaskDescription_id').val(data.TaskDescription);
                                        $('#Status_id').val(data.Status);
                                        $('#Edit-Task').modal('show');
                                    }
                                }
                            })
                        });



                        $('#Edit-Task-Form').submit(function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "../api/task_action.php",
                                type: "POST",
                                data: new FormData(this),
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(data) {
                                    if(data == 0){                                      
                                    	alert("Error Notice : Something Went Wrong"); 
                                    }                                    
                                    if(data == 1){    
                                    	alert("Success : Task Edit Successfully");        
                                        document.getElementById("Edit-Task-Form").reset();
                                        dataTable.ajax.reload();
                                        $('#Edit-Task').modal('hide');
                                    }
                                    if(data == 2){   
                                    	alert("Error Notice : Incorrect Data'");  
                                    }
                                    if(data == 9){ 
                                    	alert("Error Notice : Something Went Wrong");    
                                    }
                                    if(data == 10){   
                                    	alert("Error Notice : Task ID Incorrect");  
                                    } 
                                    if(data == 11){   
                                    	alert("Error Notice : Task Name Incorrect");  
                                    }                                    
                                    if(data == 12){  
                                    	alert("Error Notice : Task Description Name Incorrect");   
                                    }                                    
                                    if(data == 13){  
                                    	alert("Error Notice : Status Name Incorrect");   
                                    }      

                                }
                            });
                        });


                        $(document).on('click', '.delete_button', function() {
                            var TaskID = $(this).data('id');
                            $.ajax({
                                url: "../api/task_action.php",
                                method: "POST",
                                data: {
                                    TaskID: TaskID,
                                    action: 'delete_single'
                                },
                                dataType: 'JSON',
                                success: function(data) {
                                    if(data == 0){                                      
                                    	alert("Error Notice : Something Went Wrong"); 
                                    }  
                                    if(data == 1){   
                                    	alert("Success : Task Removed Successfully");  
                                        dataTable.ajax.reload();
                                    }
                                    if(data == 9){   
                                    	alert("Error Notice : Something Went Wrong");  
                                    }
                                }
                            })
                        });


                    });
                </script>
</body>
</html>