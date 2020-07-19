<?php
session_start();

if (!isset($_SESSION['student_id']) || (trim($_SESSION['student_id']) == '')) {
    header("location: login.php?id=0");
}else{
    header("location: dashboard.php?id=0");
}