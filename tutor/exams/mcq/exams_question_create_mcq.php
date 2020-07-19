<?php
include '../../../includes/setup/setup.php';
session_start();
if (!isset($_SESSION['tutor_id']) || (trim($_SESSION['tutor_id']) == '')) {
    header('location: ../../login.php?id=0');
    exit();
}
$session_id=$_SESSION['tutor_id'];function limitSize($my_file){
    if ($my_file['size']>16777215){
        echo "Please select a file with small size!";
        return false;
    }
    return true;
}

if($_GET['id']==2){
    $question_id = $_GET['qid'];
    $exam_id = $_GET['eid'];
    $tableName = 'examify_exam_'.$exam_id.'_questions';
    $question_updated = $_POST['ques'];
    $mark = $_POST['mark'];
    $A = $_POST['A'];
    $B = $_POST['B'];
    $C = $_POST['C'];
    $D = $_POST['D'];
    $ans = $_POST['ans'];
    $q_img_name = $_FILES['q-img']['name'];
    $ans_img_name = $_FILES['ans-img']['name'];
    if (limitSize($_FILES['q-img'])&&limitSize($_FILES['ans-img'])) {
        if (empty($q_img_name) && empty($ans_img_name)) {
            $sql = "INSERT INTO $tableName 
                (qid, question, option1, option2, option3, option4, answer, marks)
                VALUES ('$question_id','$question_updated','$A', '$B', '$C', '$D', '$ans','$mark')";
        } elseif (empty($ans_img_name)) {
            $q_img = addslashes(file_get_contents($_FILES['q-img']['tmp_name']));
            $sql = "INSERT INTO $tableName 
                    (qid,question, question_adds, option1, option2, option3, option4, answer, marks)
                    VALUES ('$question_id','$question_updated', ('$q_img'),'$A', '$B', '$C', '$D', '$ans','$mark')";
        } elseif (empty($q_img_name)) {
            $ans_img = addslashes(file_get_contents($_FILES['ans-img']['tmp_name']));
            $sql = "INSERT INTO $tableName 
                   (qid,question, option1, option2, option3, option4, answer, answer_adds, marks)
                   VALUES ('$question_id','$question_updated','$A', '$B', '$C', '$D', '$ans', ('$ans_img'),'$mark')";
        } else {
            $q_img = addslashes(file_get_contents($_FILES['q-img']['tmp_name']));
            $ans_img = addslashes(file_get_contents($_FILES['ans-img']['tmp_name']));
            $sql = "INSERT INTO $tableName 
                   (qid,question, question_adds, option1, option2, option3, option4, answer, answer_adds, marks)
                   VALUES ('$question_id','$question_updated', ('$q_img'),'$A', '$B', '$C', '$D', '$ans', ('$ans_img'),'$mark')";
        }
    }
    if (mysqli_query($con, $sql)){
        echo "<script>window.location.href='exams_question_builder_mcq.php?id=1&load=LOAD&eid=".$exam_id."&qid=".$question_id."'</script>";
    }else{
        echo $con->error;
    }
}