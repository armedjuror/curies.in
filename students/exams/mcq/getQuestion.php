<?php
include '../../../includes/setup/setup.php';
include "../../includes/setup/session_check.php";
$query=mysqli_query($con, "SELECT * from examify_students where sid='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);

$stud_id = $user['sid'];
$exam_id = $_POST['exam_id'];
$question_id = $_POST['q_id'];
if (empty($question_id)){
    $question_id = 1;
}

function checked($res, $opt){
    if ($res==$opt){
        return true;
    }else{
        return false;
    }
}

$q_table = 'examify_exam_'.$exam_id.'_questions';
$r_table = 'examify_exam_'.$exam_id.'_responses';
$check = mysqli_query($con, "SELECT * FROM ".$r_table." WHERE qid='$question_id' AND stud_id='$stud_id'");
$preview_object = mysqli_query($con, "SELECT * FROM $q_table WHERE qid='$question_id'");
$preview = mysqli_fetch_array($preview_object);
if ($check->num_rows){
    $response_list = mysqli_fetch_array($check);
    $userResponse = $response_list['response'];
    echo '<form action="#" class="form-horizontal form-material" id="answer-form">
        <h3 class="text-dark">QUESTION- '.$preview["qid"].'</h3>
        <div class="form-group">
            <h3>'.$preview['question'].'</h3><img src="" alt="" class="img">';
    if (!empty($preview['question_adds'])){
        echo '<img class="img img-responsive q_img" alt="img" src="data:image/jpeg;base64,'.base64_encode($preview['question_adds']).'">';
    }
    echo '</div>
        <div class="form-group">
            <div class="row">
                <label for="option1" class="col-md-3 col-sm-6 text-dark font-weight-bold">A : '.$preview['option1'].'</label>
                <div class="col-md-3 col-sm-6">';
    if (checked($userResponse, 'A')){
        echo '<input type="radio" name="answer" id="option1" checked value="A" class="form-control radio">';
    }else{
        echo '<input type="radio" name="answer" id="option1" value="A" class="form-control radio">';
    }

    echo '</div>
              <label for="option2" class="col-md-3 col-sm-6 text-dark font-weight-bold">B : '.$preview['option2'].'</label>
              <div class="col-md-3 col-sm-6">';
        if (checked($userResponse, 'B')){
            echo '<input type="radio" name="answer" id="option2" checked value="B" class="form-control radio">';
        }else{
            echo '<input type="radio" name="answer" id="option2" value="B" class="form-control radio">';
        }
    echo '</div>
            </div>
            <div class="row">
                <label for="option3" class="col-md-3 col-sm-6 text-dark font-weight-bold">C : '.$preview['option3'].'</label>
                <div class="col-md-3 col-sm-6">';
        if (checked($userResponse, 'C')){
                echo '<input type="radio" name="answer" id="option3" checked value="C" class="form-control radio">';
            }else{
            echo '<input type="radio" name="answer" id="option3" value="C" class="form-control radio">';
        }
    echo '</div>
                <label for="option4" class="col-md-3 col-sm-6 text-dark font-weight-bold">D : '.$preview['option4'].'</label>
                <div class="col-md-3 col-sm-6">';
        if (checked($userResponse, 'D')){
            echo '<input type="radio" name="answer" id="option4" checked value="D" class="form-control radio">';
        }else{
            echo '<input type="radio" name="answer" id="option4" value="D" class="form-control radio">';
        }
    echo '</div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-info" id="previous" onclick="changeQuestion(\'previous\')">PREVIOUS</button>
            <input type="reset" value="RESET" title="This will delete your recorded response" onclick="clearResponse()"  class="btn btn-danger">
            <input type="submit" value="SAVE" onclick="updateResponse()" class="btn btn-success pull-right">
            <button class="btn btn-info pull-right" id="next" onclick="changeQuestion(\'next\')">NEXT</button>
        </div>
    </form>';
}else{
    echo '<form action="#" class="form-horizontal form-material" id="answer-form">
        <h3 class="text-dark">QUESTION- '.$preview["qid"].'</h3>
        <div class="form-group">
            <h3>'.$preview['question'].'</h3><img src="" alt="" class="img">';
    if (!empty($preview['question_adds'])){
        echo '<img class="img img-responsive q_img" alt="img" src="data:image/jpeg;base64,'.base64_encode($preview['question_adds']).'">';
    }
    echo '</div>
        <div class="form-group">
            <div class="row">
                <label for="option1" class="col-md-3 col-sm-6 text-dark font-weight-bold">A : '.$preview['option1'].'</label>
                <div class="col-md-3 col-sm-6">
                    <input type="radio" name="answer" id="option1" value="A" class="form-control radio">
                </div>
                <label for="option2" class="col-md-3 col-sm-6 text-dark font-weight-bold">B : '.$preview['option2'].'</label>
                <div class="col-md-3 col-sm-6">
                    <input type="radio" name="answer" id="option2" value="B" class="form-control">
                </div>
            </div>
            <div class="row">
                <label for="option3" class="col-md-3 col-sm-6 text-dark font-weight-bold">C : '.$preview['option3'].'</label>
                <div class="col-md-3 col-sm-6">
                    <input type="radio" name="answer" id="option3" value="C" class="form-control">
                </div>
                <label for="option4" class="col-md-3 col-sm-6 text-dark font-weight-bold">D : '.$preview['option4'].'</label>
                <div class="col-md-3 col-sm-6">
                    <input type="radio" name="answer" id="option4" value="D" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-info" id="previous" onclick="changeQuestion(\'previous\')">PREVIOUS</button>
            <input type="reset" value="RESET" class="btn btn-danger">
            <input type="submit" value="SAVE" onclick="saveResponse()" class="btn btn-success pull-right">
            <button class="btn btn-info pull-right" id="next" onclick="changeQuestion(\'next\')">NEXT</button>
        </div>
    </form>';
}


?>