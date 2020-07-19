<?php
session_start();

if (!isset($_SESSION['tutor_id']) || (trim($_SESSION['tutor_id']) == '')) {
    header("location: login.php?id=0");
}else{
    header("location: dashboard.php?id=0");
}