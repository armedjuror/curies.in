<?php
include '../../../includes/setup/setup.php';
include "../../includes/setup/session_check.php";
$query=mysqli_query($con, "SELECT * from examify_students where sid='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);
function validateAnswer($response, $answer){
    if ($response == $answer){
        return true;
    }else{
        return false;
    }
}

$stud_id = $user['sid'];
$exam_id = $_POST['exam_id'];
$question_id = $_POST['q_id'];
$response = $_POST['answer'];
if (empty($question_id)){
    $question_id = 1;
}
$r_table = 'examify_exam_'.$exam_id.'_responses';
$q_table = 'examify_exam_'.$exam_id.'_questions';
$fetchQuestion = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM ".$q_table." WHERE qid='$question_id'"));
if (validateAnswer($response, $fetchQuestion['answer'])){
    $mark_scored = $fetchQuestion['marks'];
}else{
    $mark_scored = 0;
}

if ($saveResponse = mysqli_query($con, "UPDATE ".$r_table." SET response='$response', marks_scored='$mark_scored' WHERE qid='$question_id' AND stud_id='$stud_id'")){
    echo 'saved';
}else{
    echo $con->error;
}