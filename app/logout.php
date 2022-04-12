<?php
include_once('../includes/dbconnect.php');
session_unset();
session_destroy();
session_write_close();
setcookie(session_name(),'',0,'/');
$_SESSION['LoginCheck'] = date("F j, Y, g:i a");
session_regenerate_id(true);
header("Location: ../index.php");

?>
