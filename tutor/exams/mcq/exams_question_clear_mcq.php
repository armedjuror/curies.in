<?php
include '../../../includes/setup/setup.php';
session_start();
if (!isset($_SESSION['tutor_id']) || (trim($_SESSION['tutor_id']) == '')) {
    header('location: ../../login.php?id=0');
    exit();
}
$session_id=$_SESSION['tutor_id'];
$exam_id = $_GET['eid'];
$tableName = 'examify_exam_'.$exam_id.'_questions';
if ($_GET['id']==4){
    $qid = $_GET['qid'];
    if (mysqli_query($con, "DELETE FROM $tableName WHERE qid='$qid'")){
        echo "<script>window.location.href='exams_question_builder_mcq.php?id=1&load=LOAD&eid=".$exam_id."&qid=".$question_id."'</script>";
    }
}