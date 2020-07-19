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
$q_id = $_POST['qid'];

if (empty($exam_id)){
    echo '<h1 class="h1 text-center">Please select an exam</h1>';
}elseif(empty($q_id)){
    echo '<h1 class="h1 text-center">Please select a question</h1>';
}else{
    $q_table = "examify_exam_".$exam_id."_questions";
    $r_table = "examify_exam_".$exam_id."_responses";
    $exam_select = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM examify_exams WHERE eid='$exam_id'"));
    $q_count = $exam_select['question_count'];
    $response_header = mysqli_query($con, "SELECT * FROM ".$r_table." WHERE qid='$q_id' AND stud_id='$stud_id'");
    if ($response_header){
        if ($response_header->num_rows){
            $response = mysqli_fetch_array($response_header);
        }else{
            $response = array("response"=>"Not Answered", "marks_scored"=>"0");
        }
        $question = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM ".$q_table." WHERE qid='$q_id'"));
        echo '<header class="box-title h3">Question - '.$q_id.'</header>
                <p class="h3">'.$question['question'].'</p>';
        if ($question['question_adds'])
        echo '<img src="data:image/jpeg;base64,'.base64_encode($question['question_adds']).'">';
        echo '<ol type="A">
                    <li>'.$question['option1'].'</li>
                    <li>'.$question['option2'].'</li>
                    <li>'.$question['option3'].'</li>
                    <li>'.$question['option4'].'</li>
                </ol>';
        if ($question['answer_adds'])
            echo '<img src="data:image/jpeg;base64,'.base64_encode($question['question_adds']).'">';
        echo '<div class="myrow">
                    <div class="answer"><h2>Answer : '.$question['answer'].'</h2></div>
                    <div class="marks"><h2>Mark : '.$question['marks'].'</h2></div>
                    <div class="response"><h2>Your Response : '.$response['response'].'</h2></div>
                    <div class="response"><h2>Mark Scored : '.$response['marks_scored'].'</h2></div>
                </div>
                <div class="challenge">
                    <button class="btn btn-warning"  data-toggle="modal" data-target="#challengeModal">Report Question</button>
                </div>
                <div class="modal fade"  id="challengeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                         <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="exampleModalLongTitle">Report Questions</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="#" id="" class="form-horizontal form-material" style="padding: 0 10px;">
                            <div class="modal-body">
                                    <div id="select" class="form-group">
                                        <label for="exam" class="col-md-12 text-dark" >EXAM ID</label>
                                        <input type="text" name="exam" id="exam" required class="form-control form-control-line" value="'.$exam_id.'" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="questionnumber" class="col-md-12 text-dark">QUESTION NUMBER</label>
                                        <select name="questionnumber" id="questionnumber" required class="form-control form-control-line">
                                            <option value="">--SELECT A QUESTION--</option>';
                                        for ($i=1; $i<=$q_count; $i++){
                                            echo '<option value="'.$i.'">Question - '.$i.'</option>';
                                        }
                                       echo '</select>
                                    </div>
                                    <div class="form-group">
                                        <label for="problem" class="col-md-12 text-dark">PROBLEM</label>
                                        <input type="text" class="form-control form-control-line" required name="problem" id="problem" placeholder="Report your problem and suggest a solution">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" id="submit" class="btn btn-warning" onclick="reportQuestion()">REPORT QUESTION</button>
                            </div>
                            </form>
                         </div>
                    </div> 
            </div>
            <div id="model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"></div>';
    }else{
        echo $con->error;
    }

}

