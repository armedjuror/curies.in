<?php
include '../../includes/setup/setup.php';
session_start();
if (!isset($_SESSION['student_id']) || (trim($_SESSION['student_id']) == '')) {
    header('location: ../login.php?id=0');
    exit();
}
$session_id=$_SESSION['student_id'];
$query=mysqli_query($con, "SELECT * from examify_students where sid='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);
$sql = mysqli_query($con, 'SELECT * FROM examify_portal WHERE id=2');
$portal = mysqli_fetch_array($sql);
if (isset($_GET['eid'])){
    $exam_id = $_GET['eid'];
    $exam = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM examify_exams WHERE eid='$exam_id'"));
}
if (mysqli_query($con, "SELECT * FROM examify_exam_".$exam_id."_responses WHERE stud_id='".$user['sid']."'" )->num_rows){
    echo '<script>alert("You\'ve attempted exam once!");
            window.location.href="../exams_single.php?id=1&&eid='.$exam_id.'"</script>';
}

?>
<!doctype html>
<html lang="en">
<head>
    <title>Exam | <?php echo $portal['name'];?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="../includes/plugins/images/favicon.png">
</head>
<body>

<div class="wrapper d-flex align-items-stretch">

    <!--Navigation-->
    <nav id="sidebar">
        <div class="custom-menu">
            <button type="button" id="sidebarCollapse" class="btn btn-primary">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Toggle Menu</span>
            </button>
        </div>
        <div class="p-4">
            <h1><a href="index.php" class="logo"><?php echo $portal['name'];?> <span>Powered by Examify</span></a></h1>
            <ul class="list-unstyled components mb-5">
                <li>
                    <a href="#" onclick="techInstructions()"><span class="fa fa-cogs mr-3"></span>Technical Instructions</a>
                </li>
                <li>
                    <a href="#" onclick="examInstructions()"><span class="fa fa-briefcase mr-3"></span>Exam Instructions</a>
                </li>

            </ul>

            <div class="mb-5">
                <h3 class="text-white mb-3">USER INFO</h3>
                <h3 class="h6 mb-3">NAME : <?php echo $user['name'];?></h3>
                <h3 class="h6 mb-3">USERNAME : <?php echo $user['username'];?></h3><br>
            </div>
            <div class="mb-5">
                <h3 class="h6 mb-3">SELECT QUESTION</h3>
                <form>
                    <input type="text" id="exam_id" value="<?php echo $exam_id;?>" hidden>
                    <input type="number" id="duration" value="<?php echo $exam['duration'];?>" hidden>
                    <div class="form-group d-flex">
                        <select class="form-control" name="qid" id="QuestionList" onchange="changeQuestion('')" required>
                            <?php
                            $total_questions = (int)$exam['question_count'];
                            echo "<option value=''>--SELECT QUESTION--</option>";
                            for ($i=1; $i<=$total_questions; $i+=1){
                                echo "<option value='".$i."'>Question-".$i."</option>";
                            }
                            ?>
                        </select>
                        <input type="number" hidden id="q_count" value="<?php echo $total_questions;?>">
                        <input type="number" hidden id="user" value="<?php echo $user['sid'];?>">
                    </div>
                </form>
            </div>
            <div class="mb-5">
                <h1 class="h1 text-center text-white">TIMER</h1>
                <h2 class="h2 mb-3 text-white text-center" id="timer">00:59:23</h2>
            </div>
            <div class="mb-5">
                <form action="#">
                    <div class="form-group d-flex">
                        <input type="button" value="SUBMIT EXAM" class="btn btn-success btn-block" onclick="submitExam()" >
                    </div>
                </form>
            </div>

            <div class="footer text-justify">
                Submitting your exam won't save your data. So save it first and submit after completing all questions.
            </div>

        </div>
    </nav>

    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
        <h1 class="text-center font-weight-bold">Please select a Question</h1>
    </div>
</div>
<script>
    window.onbeforeunload = function () {
        return "Do you really want to continue? This will make your test submit. Please don't reload or close if you want to continue exam."
    }
    window.onload = function () {
        techInstructions()
    }
    function changeQuestion(oper) {
        let question = new XMLHttpRequest()
        let url = "mcq/getQuestion.php"
        let total_question = parseInt(document.getElementById('q_count').value)
        let exam_id = document.getElementById('exam_id').value
        let q_id = document.getElementById('QuestionList').value
        if (q_id===''){
            q_id=1
        }
        q_id = parseInt(q_id)
        if (oper==='next'){
            if (q_id<total_question){
                q_id++
            }else {
                alert("This is the last question. If you are done with all. Please submit the test")
            }
        }else if(oper==='previous'){
            if (q_id>1){
                q_id--
            }else {
                alert("This is the first question.")
            }
        }
        let varList = "exam_id="+exam_id+"&q_id="+q_id
        question.open('POST', url, true)
        question.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        question.onreadystatechange = function () {
            if (question.readyState === 4 && question.status === 200){
                document.getElementById('content').innerHTML = question.responseText
            }
        }
        question.send(varList)
        document.getElementById('QuestionList').value = q_id
        document.getElementById('content').innerHTML = '<h1 class="text-center font-weight-bold">Processing...</h1>'
    }

    function saveResponse() {
        let userResponse = new XMLHttpRequest()
        let url = "mcq/saveResponse.php"
        let exam_id = document.getElementById('exam_id').value
        let q_id = document.getElementById('QuestionList').value
        let responseValue = getRadioVal(document.getElementById('answer-form'), 'answer')
        console.log(responseValue)
        let varList = "exam_id="+exam_id+"&q_id="+q_id+"&answer="+responseValue
        userResponse.open('POST', url, true)
        userResponse.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        userResponse.onreadystatechange = function () {
            if (userResponse.readyState === 4 && userResponse.status === 200) {
                let submissionStatus = userResponse.responseText
                if (submissionStatus==='saved'){
                    changeQuestion('next')
                }else{
                    document.getElementById('content').innerHTML = submissionStatus
                }
            }
        }
        userResponse.send(varList)
        document.getElementById('content').innerHTML = '<h1 class="text-center font-weight-bold">Data Saved. Next Question</h1>'
    }

    function updateResponse() {
        let userResponse = new XMLHttpRequest()
        let url = "mcq/updateResponse.php"
        let exam_id = document.getElementById('exam_id').value
        let q_id = document.getElementById('QuestionList').value
        let responseValue = getRadioVal(document.getElementById('answer-form'), 'answer')
        console.log(responseValue)
        let varList = "exam_id="+exam_id+"&q_id="+q_id+"&answer="+responseValue
        userResponse.open('POST', url, true)
        userResponse.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        userResponse.onreadystatechange = function () {
            if (userResponse.readyState === 4 && userResponse.status === 200) {
                let submissionStatus = userResponse.responseText
                if (submissionStatus==='saved'){
                    changeQuestion('next')
                }else{
                    document.getElementById('content').innerHTML = submissionStatus
                }
            }
        }
        userResponse.send(varList)
        document.getElementById('content').innerHTML = '<h1 class="text-center font-weight-bold">Data Saved. Next Question</h1>'
    }

    function clearResponse() {
        let userResponse = new XMLHttpRequest()
        let url = "mcq/clearResponse.php"
        let exam_id = document.getElementById('exam_id').value
        let q_id = document.getElementById('QuestionList').value
        let responseValue = getRadioVal(document.getElementById('answer-form'), 'answer')
        console.log(responseValue)
        let varList = "exam_id="+exam_id+"&q_id="+q_id+"&answer="+responseValue
        userResponse.open('POST', url, true)
        userResponse.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        userResponse.onreadystatechange = function () {
            if (userResponse.readyState === 4 && userResponse.status === 200) {
                let submissionStatus = userResponse.responseText
                if (submissionStatus==='saved'){
                    changeQuestion('')
                }else{
                    document.getElementById('content').innerHTML = submissionStatus
                }
            }
        }
        userResponse.send(varList)
        document.getElementById('content').innerHTML = '<h1 class="text-center font-weight-bold">Data Saved. Next Question</h1>'
    }

    function getRadioVal(form, name) {
        let val;
        let radios = form.elements[name];
        for (let i=0, len=radios.length; i<len; i++) {
            if ( radios[i].checked ) {
                val = radios[i].value;
                break;
            }
        }
        return val;
    }

    function techInstructions() {
        let techInstruct = new XMLHttpRequest()
        let url = "mcq/exam_tech_instruction.php"
        techInstruct.open('POST', url, true)
        techInstruct.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        techInstruct.onreadystatechange = function () {
            if (techInstruct.readyState === 4 && techInstruct.status === 200) {
                let instruction = techInstruct.responseText
                document.getElementById('content').innerHTML = instruction
            }
        }
        techInstruct.send()
        document.getElementById('content').innerHTML = '<h1 class="text-center font-weight-bold">Instruction Loading...</h1>'
    }

    function examInstructions() {
        let examInstruction = new XMLHttpRequest()
        let url = "exam_examInstruction.php"
        let exam_id = document.getElementById('exam_id').value
        let varList = "exam_id="+exam_id
        examInstruction.open('POST', url, true)
        examInstruction.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        examInstruction.onreadystatechange = function () {
            if (examInstruction.readyState === 4 && examInstruction.status === 200) {
                let instruction = examInstruction.responseText
                document.getElementById('content').innerHTML = instruction
            }
        }
        examInstruction.send(varList)
        document.getElementById('content').innerHTML = '<h1 class="text-center font-weight-bold">Instruction Loading...</h1>'
    }
    
    function submitExam() {
        let submit = new XMLHttpRequest()
        let url = "mcq/submitExam.php"
        let exam_id = document.getElementById('exam_id').value
        let varList = "exam_id="+exam_id
        submit.open('POST', url, true)
        submit.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        submit.onreadystatechange = function () {
            if (submit.readyState === 4 && submit.status === 200) {
                document.getElementById('content').innerHTML = submit.responseText
            }
        }
        submit.send(varList)
        document.getElementById('content').innerHTML = '<h1 class="text-center font-weight-bold"></h1>'
    }
</script>
<script src="js/app.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>