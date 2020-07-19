<?php
include '../../includes/setup/setup.php';
session_start();
if (!isset($_SESSION['tutor_id']) || (trim($_SESSION['tutor_id']) == '')) {
    header('location: ../login.php?id=0');
    exit();
}
$session_id=$_SESSION['tutor_id'];
//Close Exam
if ($_GET['id']==1){
    $e_id = $_GET['eid'];
    if (mysqli_query($con, "UPDATE examify_exams SET closed=true WHERE `eid`='$e_id'")){
        echo "<script>window.location.href='../exams_single.php?id=1&eid=".$e_id."'</script>";
    }
}
//Reopen Exam
if ($_GET['id']==2){
    $e_id = $_GET['eid'];
    if (mysqli_fetch_array(mysqli_query($con, "SELECT completed FROM examify_exams WHERE eid='$e_id'"))['completed']==0){
        if (mysqli_query($con, "UPDATE examify_exams SET closed=0 WHERE eid='$e_id'")){
            echo "<script>window.location.href='../exams_single.php?id=1&eid=".$e_id."'</script>";
        }else{
            echo $con->error;
        }
    }else{
        echo '<script>alert("This exam is completed with publishing answer key. Unable to re-open it.");
                window.location.href="../exams_single.php?id=1&eid='.$e_id.'";</script>';

    }
}
function evaluateExam($exam_id, $connection){
//    updating Status as completed
    echo "Initiated completion of exam of id : ".$exam_id."<br>";
    mysqli_query($connection, "UPDATE examify_exams SET completed=1 WHERE eid='$exam_id';");
    mysqli_query($connection, "UPDATE examify_exams SET closed=1 WHERE eid='$exam_id';");
    echo "Updated Status...<br>";

    $q_table = "examify_exam_".$exam_id."_questions";
    $r_table = "examify_exam_".$exam_id."_responses";
    $m_table = "examify_exam_".$exam_id."_marklist";

//  Evaluating Each Responses
    echo "Evaluating each responses...<br>";
    $allResponses = mysqli_query($connection, "SELECT * FROM ".$r_table.";");
    if ($allResponses->num_rows){
        echo "Evaluating each responses...<br>";
        while ($response = mysqli_fetch_array($allResponses)){
            $q_no = $response['qid'];
            $recorded_response = $response['response'];
            $resp_id = $response['resp_id'];
            $fetch_question = mysqli_fetch_array(mysqli_query($connection, "SELECT answer, marks FROM ".$q_table." WHERE qid='$q_no'"));
            if ($recorded_response == $fetch_question['answer']){
                $marks_scored = $fetch_question['marks'];
            }else{
                $marks_scored = 0;
            }
            mysqli_query($connection, "UPDATE ".$r_table." SET marks_scored='".$marks_scored."' WHERE resp_id='$resp_id';");
        }
    }
    echo "Evaluated each responses...<br>";

//  Getting List of all participants
    $participants = mysqli_query($connection, "SELECT DISTINCT stud_id FROM ".$r_table.";");
    if ($participants->num_rows){
        echo "Updating Mark list...<br>";
        while($participant = mysqli_fetch_array($participants)){
            $stud_id = $participant['stud_id'];
            $total_marks = (float)mysqli_fetch_array(mysqli_query($connection, "SELECT SUM(marks_scored) AS total FROM ".$r_table." WHERE stud_id='$stud_id';"))['total'];

//          Updating mark list
            mysqli_query($connection, "INSERT INTO ".$m_table." (stud_id, mark) VALUES ('$stud_id', '$total_marks') ON DUPLICATE KEY UPDATE mark=VALUES(mark);");
        }
    }
    echo "Successully evaluated!";
}

if ($_GET['id']==3){
    $e_id = $_GET['eid'];
    evaluateExam($e_id,$con);
    echo "This page will be redirected in 10s. if not <a href='exams_single.php?id=1&eid=".$e_id."'>click here</a>.";
    echo "<script>setTimeout(function() {
      window.location.href = '../exams_single.php?id=1&eid=".$e_id."';
    },10000)</script>";
}