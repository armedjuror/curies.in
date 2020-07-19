<?php
session_start();

if (!isset($_SESSION['user_id']) || (trim($_SESSION['user_id']) == '')) {
    header("location: login.php?id=0");
}else{
    header("location: dashboard.php");
}