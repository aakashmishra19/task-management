<?php
include_once '../includes/dbconnect.php';
include_once '../includes/_commonFun.php';
$directoryName = "../../auditor/resourses/organization_logo";

if (loggedin()) {


        if ($_POST['action'] == 'fetch_data') {
            $params = $columns = $totalRecords = $data = array();
            $params = $_REQUEST;
            $columns = array(
                0 => 'ID',
                1 => 'TaskID',
                2 => 'TaskName',
                3 => 'Status',
                4 => 'CreateDate',
            );
            $where = $sqlTot = $sqlRec = "";
            $where .= " WHERE ";
            $where .= " UserID = '".$UserID."' ";
            if (!empty($params['search']['value'])) {
                $where .= "AND ( TaskID LIKE '%" . $params['search']['value'] . "%' ";
                $where .= " OR TaskName LIKE '%" . $params['search']['value'] . "%' ";
                $where .= " OR Status LIKE '%" . $params['search']['value'] . "%' ";
                $where .= " OR CreateDate LIKE '%" . $params['search']['value'] . "%' ) ";
            }
            $sql = "SELECT * FROM `task` ";
            $sqlTot .= $sql;
            $sqlRec .= $sql;
            if (isset($where) && $where != '') {
                $sqlTot .= $where;
                $sqlRec .= $where;
            }
            $sqlRec .= " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . "  LIMIT " . $params['start'] . " ," . $params['length'] . " ";
            $queryTot = mysqli_query($conn, $sqlTot) or die("database error:" . mysqli_error($conn));
            $totalRecords = mysqli_num_rows($queryTot);
            $queryRecords = mysqli_query($conn, $sqlRec) or die("error to fetch employees data");
            while ($row = $queryRecords->fetch_assoc()) {
                $subarr = array();

                $subarr[] ="<h5><span class='badge bg-primary'><i class='mdi mdi-circle-medium'></i> ".$row["TaskID"]."</span></h5>";

                $subarr[] = $row["TaskName"];


                if ($row["Status"] == 'Completed') {
                    $subarr[] = "<span class='badge bg-success text-uppercase'>" . $row["Status"] . "</span>";
                } elseif ($row["Status"] == 'Uncompleted') {
                    $subarr[] = "<span class='badge bg-danger text-uppercase'>" . $row["Status"] . "</span>";
                } else {
                    $subarr[] = "<span class='badge bg-warning text-uppercase'>" . $row["Status"] . "</span>";
                }


                $subarr[] = $row["CreateDate"];


                $subarr[] = "<button class='btn btn-sm btn-warning edit-item-btn me-2 edit_button' type='button' name='edit_button' data-id='" . $row["TaskID"] . "'>Edit</button>
                <button class='btn btn-sm btn-danger edit-item-btn me-2 delete_button' type='button' name='delete_button' data-id='" . $row["TaskID"] . "'>Delete</button>";

                $data[] = $subarr;
            }
            $json_data = array(
                "draw" => intval($params['draw']),
                "recordsTotal" => intval($totalRecords),
                "recordsFiltered" => intval($totalRecords),
                "data" => $data,
            );
            echo json_encode($json_data);
        } elseif ($_POST['action'] == 'add_task') {
            $TaskID = randome10();
            $sql = "SELECT TaskID FROM task WHERE TaskID = '$TaskID'";
            $result = $conn->query($sql);
            while ($result->num_rows > 0) {
                $TaskID = randome10();
                $sql = "SELECT TaskID FROM task WHERE TaskID = '$TaskID'";
                $result = $conn->query($sql);
            }
            if (!empty($_POST['TaskName']) && !empty($_POST['TaskDescription']) && !empty($_POST['Status'])) {
                if (!preg_match("/^[0-9a-zA-Z-. ]{4,50}$/", $_POST['TaskName'])) {
                        echo 11;
                }elseif (!preg_match("/^[a-zA-Z0-9,.-_:!@#$%&* ]{4,3000}$/", $_POST['TaskDescription'])) {
                    echo 12;
                }elseif (!preg_match("/^[a-zA-Z ]{4,20}$/", $_POST['Status'])) {
                    echo 13;
                }else{
                    $TaskName = $conn->real_escape_string($_POST['TaskName']);
                    $TaskDescription = $conn->real_escape_string($_POST['TaskDescription']);
                    $Status = $conn->real_escape_string($_POST['Status']);
                    $ModificationTimeline['ModificationTimeline'][0]['Status'] = $Status;
                    $ModificationTimeline['ModificationTimeline'][0]['ModifiedBy'] = $UserID;
                    $ModificationTimeline['ModificationTimeline'][0]['ModifiedDateTime'] = $timestamp;
                    $ModificationTimelineJSON = json_encode($ModificationTimeline);

                    $query1 = "INSERT INTO task  (UserID,TaskID,TaskName,TaskDescription,Status,CreateDate,ModificationTimeline)  VALUES('$UserID','$TaskID','$TaskName','$TaskDescription','$Status','$date','$ModificationTimelineJSON')";
                    if ($conn->query($query1) === true) {
                        echo 1;
                    } else {
                        echo 0;
                    }
                }
            } else {
                echo 2;
            }
        } elseif ($_POST['action'] == 'fetch_single') {
            if (!empty($_POST['TaskID'])) {
                $TaskID = $conn->real_escape_string($_POST['TaskID']);
                if (!preg_match("/^[0-9]{10}$/", $_POST['TaskID'])) {
                    echo 31;
                }else{
                    $sql = "SELECT * FROM task WHERE TaskID = '$TaskID' && UserID = '$UserID'";
                    $result = $conn->query($sql);
                    $countA = mysqli_num_rows($result);
                    if ($countA > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $subarr = array();
                            $subarr['TaskID'] = $row["TaskID"];
                            $subarr['TaskName'] = $row["TaskName"];
                            $subarr['TaskDescription'] = $row["TaskDescription"];
                            $subarr['Status'] = $row["Status"];
                        }
                        echo json_encode($subarr);
                    } else {
                        echo 0;
                    }
                }
            } else{
                echo 2;
            }
        } elseif ($_POST['action'] == 'edit_task') {
            if (!empty($_POST['TaskID'])) {
                $TaskID = $conn->real_escape_string($_POST['TaskID']);
                if (!preg_match("/^[0-9]{10}$/", $_POST['TaskID'])) {
                    echo 10;
                }else{
                    if (!empty($_POST['TaskName']) && !empty($_POST['TaskDescription']) && !empty($_POST['Status'])) {
                        if (!preg_match("/^[0-9a-zA-Z-. ]{4,50}$/", $_POST['TaskName'])) {
                                echo 11;
                        }elseif (!preg_match("/^[a-zA-Z0-9,.-_:!@#$%&* ]{4,3000}$/", $_POST['TaskDescription'])) {
                            echo 12;
                        }elseif (!preg_match("/^[a-zA-Z ]{4,20}$/", $_POST['Status'])) {
                            echo 13;
                        }else {
                            $TaskName = $conn->real_escape_string($_POST['TaskName']);
                            $TaskDescription = $conn->real_escape_string($_POST['TaskDescription']);
                            $Status = $conn->real_escape_string($_POST['Status']);
                            $sql1 = "SELECT * FROM task  WHERE TaskID = '$TaskID' && UserID = '$UserID'";
                            $result1 = $conn->query($sql1);
                            $countA1 = mysqli_num_rows($result1);
                            if ($countA1 == 1) {
                                $row1 = $result1->fetch_assoc();
                                $ModificationTimeline = json_decode($row1["ModificationTimeline"], true);
                                $countModi = count($ModificationTimeline['ModificationTimeline']);
                                $ModificationTimeline['ModificationTimeline'][$countModi]['Status'] = $Status;
                                $ModificationTimeline['ModificationTimeline'][$countModi]['ModifiedBy'] = $UserID;
                                $ModificationTimeline['ModificationTimeline'][$countModi]['ModifiedDateTime'] = $timestamp;
                                $ModificationTimeline = json_encode($ModificationTimeline);

                                $sqlCDAE001 = "UPDATE task SET TaskName='$TaskName',TaskDescription='$TaskDescription',Status='$Status',ModificationTimeline='$ModificationTimeline' WHERE  TaskID = '$TaskID' && UserID = '$UserID'";
                                if ($conn->query($sqlCDAE001) === true) {
                                    echo 1;
                                } else {
                                    echo 0;
                                }
                            }else{
                                echo 2;
                            }
                        }
                    } else {
                        echo 2;
                    }
                }
            } else{
                echo 10;
            }
        } elseif ($_POST['action'] == 'delete_single') {
            if (!empty($_POST['TaskID'])) {
                $TaskID = $conn->real_escape_string($_POST['TaskID']);
                if (!preg_match("/^[0-9]{10}$/", $_POST['TaskID'])) {
                    echo 10;
                }else{   
                    $sql = "DELETE FROM task WHERE TaskID = '$TaskID' && UserID = '$UserID' ";
                    if ($conn->query($sql) === true) {
                        echo "1";
                    } else {
                        echo "0";
                    }
                }
            } else{
                echo 2;
            }
        } else{
            echo 9;
        }


} else {
    header("Location: ../app/logout.php");
}



?>