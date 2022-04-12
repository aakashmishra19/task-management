<?php
session_start();

function loggedin()
{
    if (isset($_SESSION['UserID']) && !empty($_SESSION['UserID']) && isset($_SESSION['UserEmail']) && !empty($_SESSION['UserEmail']) && isset($_SESSION['LoginCheck']) && !empty($_SESSION['LoginCheck']) && $_SESSION['LoginCheck'] == "Login_Successfully") {
        session_regenerate_id();
        return true;
    } else {
        session_regenerate_id();
        return false;
    }
}
if (!empty($_SESSION['UserID']) && !empty($_SESSION['UserEmail'])) {
    $Session_UserID = $_SESSION['UserID'];
    $Session_Email = $_SESSION['UserEmail'];

    $sqlLoginS001 = "SELECT * FROM users WHERE BINARY UserID = '$Session_UserID' AND UserEmail='$Session_Email' ";
    $resultlLoginS001 = $conn->query($sqlLoginS001); 
    $count = mysqli_num_rows($resultlLoginS001);

    if ($count == 1) {
        $run = $resultlLoginS001->fetch_array(MYSQLI_ASSOC);
        $UserID= $run['UserID'];
        $UserFullName = $run['UserFullName'];
        $UserEmail = $run['UserEmail'];
        $PasswordSHA = $run['UserPassword'];
    }
}
