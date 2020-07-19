<?php
include '../../../includes/setup/setup.php';
include "../../includes/setup/session_check.php";
$query=mysqli_query($con, "SELECT * from examify_students where sid='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);

$stud_id = $user['sid'];
$exam_id = $_POST['exam_id'];
$question_id = $_POST['q_id'];

$r_table = 'examify_exam_'.$exam_id.'_responses';
$q_table = 'examify_exam_'.$exam_id.'_questions';

if ($clearResponse = mysqli_query($con, "DELETE FROM ".$r_table." WHERE qid='$question_id' AND stud_id='$stud_id'")){
    echo 'saved';
}else{
    echo $con->error;
}