<?php
//Start session
session_start();
//Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['tutor_id']) || (trim($_SESSION['tutor_id']) == '')) {
    header('location: login.php?id=0');
    exit();
}
$session_id=$_SESSION['tutor_id'];

?>
