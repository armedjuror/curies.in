<?php
include '../includes/setup/setup.php';
include 'session.php';
$query=mysqli_query($con, "SELECT * from examify_students where sid='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);
$stud_id = $user['sid'];
$tut_id = $user['tut_id'];
$sql = mysqli_query($con, 'SELECT * FROM examify_portal WHERE id=2');
$portal = mysqli_fetch_array($sql);

$exam_id = $_POST['exam_id'];

if (empty($exam_id)){
    echo '<h1 class="h1 text-center">Please select an exam</h1>';
}else{
    $q_table = "examify_exam_".$exam_id."_questions";
    $r_table = "examify_exam_".$exam_id."_responses";
    $exam_select = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM examify_exams WHERE eid='$exam_id'"));
    $q_count = $exam_select['question_count'];
    echo '<div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                <input type="text" name="exam_id" id="exam_id" value="'.$exam_id.'" hidden>
                <select class="form-control pull-right row b-none" id="qid" name="qid" required onchange="loadQuestion(this.value)">
                    <option value="">--SELECT QUESTION--</option>';
    for ($i=1; $i<=$q_count; $i++){
                echo '<option value="'.$i.'">Question - '.$i.'</option>';
    }
    echo '</select></div>
          <div id="question"><h1 class="h1 text-center"><br><br>'.$exam_select['topic'].' loaded.<br>Please select a question</h1></div>';
}

