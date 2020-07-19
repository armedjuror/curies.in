<?php
include '../../includes/setup/setup.php';
session_start();
if (!isset($_SESSION['tutor_id']) || (trim($_SESSION['tutor_id']) == '')) {
    header('location: ../login.php?id=0');
    exit();
}
$session_id=$_SESSION['tutor_id'];
$query=mysqli_query($con, "SELECT * from examify_tutors where id='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);
$sql = mysqli_query($con, 'SELECT * FROM examify_portal WHERE id=2');
$portal = mysqli_fetch_array($sql);

if (isset($_POST['update'])){
    $exam_id = $_POST['exam_id'];
    $topic = $_POST['topic'];
    $instr = $_POST['instr'];
    $deadline = $_POST['deadline'];
    $ques_count = $_POST['qno'];
    $sql = "UPDATE examify_exams SET 
                                        topic = '$topic',
                                        instructions = '$instr',
                                        deadline = '$deadline',
                                        question_count = '$ques_count'
                                        WHERE eid='$exam_id'
                                        ";
    if (mysqli_query($con, $sql)){
        echo '<script>window.location.href="../exams_single.php?id=1&eid='.$exam_id.'";</script>';
    }else{
        echo $sql;
        echo $con->error;
    }
}