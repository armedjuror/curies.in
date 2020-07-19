<?php
include '../../../includes/setup/setup.php';
include "../../includes/setup/session_check.php";
$query=mysqli_query($con, "SELECT * from examify_students where sid='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);

$stud_id = $user['sid'];
$exam_id = $_POST['exam_id'];
$exam_details = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM examify_exams WHERE eid='$exam_id'"));
$r_table = 'examify_exam_'.$exam_id.'_responses';
$m_table = 'examify_exam_'.$exam_id.'_marklist';
$total_marks = $exam_details['marks'];
$total_questions = $exam_details['question_count'];
$marks = 0;
for ($q_id = 1; $q_id<=$total_questions; $q_id++){
    $checkResponse = mysqli_query($con, "SELECT * FROM ".$r_table." WHERE qid='$q_id' AND stud_id='$stud_id'");
    if ($checkResponse->num_rows){
        $fetchResponse = mysqli_fetch_array($checkResponse);
        $marks += $fetchResponse['marks_scored'];
    }
}
$score = mysqli_fetch_array(mysqli_query($con, "SELECT score FROM examify_students WHERE sid='$stud_id'"))['score'];
$score += $marks*10/$total_marks;
$saveExam = mysqli_query($con, "INSERT INTO ".$m_table." (stud_id, mark) VALUES ('$stud_id', '$marks')");
$updateProfile = mysqli_query($con, "UPDATE examify_students SET score='$score' WHERE sid='$stud_id'");
if ($saveExam && $updateProfile){
    echo "<h2 class='h2 text-center text-success'>Congratulations! You have completed the examination</h2>";
    echo "<a href='../exams.php'><button class='btn btn-success align-content-center'>GO BACK</button></a>";
}else{
    echo $con->error;
}