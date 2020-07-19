<?php
include '../includes/setup/setup.php';
include 'session.php';
$query=mysqli_query($con, "SELECT * from examify_tutors where id='$session_id'")or header('location:login.php?id=0');
$user=mysqli_fetch_array($query);
$sql = mysqli_query($con, 'SELECT * FROM examify_portal WHERE id=2');
$portal = mysqli_fetch_array($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="includes/plugins/images/favicon.png">
    <title><?php echo $portal['name']; ?> | Examify</title>
    <link href="includes/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="includes/plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <link href="includes/plugins/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="includes/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="includes/css/animate.css" rel="stylesheet">
    <link href="includes/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="includes/css/dash.css">
    <link href="includes/css/colors/default.css" id="theme" rel="stylesheet">
</head>

<body class="fix-header">
<!--Pre-loader-->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
    </svg>
</div>

<div id="wrapper">
    <?php include "navigation.php"; ?>
    <!--Page Content-->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Exams</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php?id=0">Dashboard</a></li>
                        <li class="active">Exams</li>
                    </ol>
                </div>
            </div>
            <!--Your Exams-->
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title">Your Exams</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>TOPIC</th>
                                    <th>TYPE</th>
                                    <th>DEADLINE</th>
                                    <th>QUESTION COUNT</th>
                                    <th>DURATION</th>
                                    <th>OPERATIONS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                //Displaying Exams
                                $creator = $user['id'];
                                $exam_object = mysqli_query($con, "SELECT * FROM examify_exams WHERE tut_id=$creator ORDER BY deadline DESC");
                                $my_count = $exam_object->num_rows;
                                echo $my_count;
                                if($my_count){
                                    $i = 1;
                                    while ($exam = mysqli_fetch_array($exam_object)){
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $exam['eid']; ?></td>
                                            <td><?php echo $exam['topic']; ?></td>
                                            <td><?php echo strtoupper($exam['type']); ?></td>
                                            <td><?php echo $exam['deadline']; ?></td>
                                            <td><?php echo $exam['question_count']; ?></td>
                                            <td><?php echo $exam['duration']; ?></td>
                                            <td>
                                                <a href="<?php echo 'exams_single.php?id=1&&eid='.$exam['eid'];?>">VIEW</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                <?php
                                                if ($exam['completed'] == 0){
                                                    ?>
                                                    <a href="<?php echo "exams/exams_status.php?id=1&&eid=".$exam['eid']; ?>">CLOSE</a>&nbsp;&nbsp;|
                                                    <?php
                                                }else{
                                                    ?>
                                                    <a href="<?php echo "exams/exams_status.php?id=2&&eid=".$exam['eid']; ?>">RE-OPEN</a>&nbsp;&nbsp;|
                                                    <?php
                                                }
                                                ?>
                                                <a href="<?php echo 'exams/exams_delete.php?id=1&eid='.$exam['eid'];?>">CLEAR</a>
                                            </td>
                                        </tr>
                                        <?php
                                        $i = $i+1;
                                    }
                                }
                                ?>
                                        <tr>
                                            <form action="#" method="post" name="CreateExam">
                                                <td>#</td>
                                                <td>ID will be generated!</td>
                                                <td><input class="examCreate" type="text" name="topic" id="topic" placeholder="TOPIC" required></td>
                                                <td><select class="examCreate" name="type" id="type" required>
                                                        <option value="">--TYPE_OF_TEST--</option>
                                                        <option value="mcq">MCQ</option>
                                                    </select></td>
                                                <td><input class="examCreate" type="datetime-local" name="time" id="time" required></td>
                                                <td><input class="examCreate" type="number" name="qno" id="qno" placeholder="QUESTION COUNT" required></td>
                                                <td><input class="examCreate" type="number" name="duration" id="duration" placeholder="DURATION (in mins)" required></td>
                                                <td><input type="submit" name="create" id="create" value="CREATE" class="btn-rounded btn btn-primary btn-outline"></td>
                                            </form>
                                            <?php
                                                //Create Exam
                                                if(isset($_POST['create'])){
                                                        $exam_id = uniqid("examify_");
                                                        $creator = $user['id'];
                                                        $topic  = $_POST['topic'];
                                                        $type = $_POST['type'];
                                                        $deadline = $_POST['time'];
                                                        $qno = $_POST['qno'];
                                                        $duration =$_POST['duration'];

                                                        $examCreate = "INSERT INTO examify_exams 
                                                        (eid, tut_id, topic, type, deadline, question_count, marks, duration, completed)
                                                        VALUES 
                                                        ('$exam_id','$creator','$topic','$type','$deadline','$qno', 0,'$duration',0)";

                                                        if (mysqli_query($con, $examCreate)){
                                                            if ($type=='sa'){
                                                                $createQuestionTable = "CREATE TABLE examify_exam_".$exam_id."_questions 
                                                                    ( 
                                                                    `qid` INT NOT NULL AUTO_INCREMENT , 
                                                                    `question` VARCHAR(1024) NOT NULL , 
                                                                    `question_adds` MEDIUMBLOB NULL DEFAULT NULL , 
                                                                    `answer` VARCHAR(1024) NULL DEFAULT NULL , 
                                                                    `answer_adds` MEDIUMBLOB NULL DEFAULT NULL , 
                                                                    `marks` INT NOT NULL , 
                                                                    `IsMandatory` BOOLEAN NOT NULL DEFAULT 1 , 
                                                                    PRIMARY KEY (`qid`))";

                                                                $createResponseTable = "CREATE TABLE examify_exam_".$exam_id."_responses 
                                                                    (
                                                                    `resp_id` INT NOT NULL AUTO_INCREMENT,
                                                                    `qid` INT NOT NULL,
                                                                    `stud_id` INT NOT NULL,
                                                                    `response` VARCHAR(1024) NULL DEFAULT NULL,
                                                                    `response_adds` MEDIUMBLOB NULL DEFAULT NULL,
                                                                    `marks_scored` INT NULL DEFAULT NULL,
                                                                    PRIMARY KEY (`resp_id`))";

                                                            }elseif ($type=='mcq'){
                                                                $createQuestionTable = "CREATE TABLE examify_exam_".$exam_id."_questions 
                                                                    ( 
                                                                    `qid` INT NOT NULL AUTO_INCREMENT , 
                                                                    `question` VARCHAR(1024) NOT NULL , 
                                                                    `question_adds` MEDIUMBLOB NULL DEFAULT NULL , 
                                                                    `option1` VARCHAR(255) NOT NULL , 
                                                                    `option2` VARCHAR(255) NOT NULL ,
                                                                    `option3` VARCHAR(255) NOT NULL ,
                                                                    `option4` VARCHAR(255) NOT NULL ,
                                                                    `answer` VARCHAR(8) NOT NULL ,
                                                                    `answer_adds` MEDIUMBLOB NULL DEFAULT NULL,
                                                                    `marks` INT NOT NULL , 
                                                                    `IsMandatory` BOOLEAN NOT NULL DEFAULT 1 , 
                                                                    PRIMARY KEY (`qid`))";

                                                                $createResponseTable = "CREATE TABLE examify_exam_".$exam_id."_responses 
                                                                    (
                                                                    `resp_id` INT NOT NULL AUTO_INCREMENT,
                                                                    `qid` INT NOT NULL,
                                                                    `stud_id` INT NOT NULL,
                                                                    `response` VARCHAR(8) NULL DEFAULT NULL,
                                                                    `marks_scored` INT NULL DEFAULT NULL,
                                                                    PRIMARY KEY (`resp_id`))";
                                                            }else{
                                                                $createQuestionTable = "CREATE TABLE examify_exam_".$exam_id."_questions 
                                                                    ( 
                                                                    `qid` INT NOT NULL AUTO_INCREMENT , 
                                                                    `question` VARCHAR(1024) NOT NULL , 
                                                                    `question_adds` MEDIUMBLOB NULL DEFAULT NULL , 
                                                                    `answer` VARCHAR(1024) NULL DEFAULT NULL, 
                                                                    `answer_adds` MEDIUMBLOB NULL DEFAULT NULL , 
                                                                    `marks` INT NOT NULL , 
                                                                    `IsMandatory` BOOLEAN NOT NULL DEFAULT 1, 
                                                                    PRIMARY KEY (`qid`))";

                                                                $createResponseTable = "CREATE TABLE examify_exam_".$exam_id."_responses 
                                                                    (
                                                                    `resp_id` INT NOT NULL AUTO_INCREMENT,
                                                                    `qid` INT NOT NULL,
                                                                    `stud_id` INT NOT NULL,
                                                                    `response` LONGBLOB NULL DEFAULT NULL,
                                                                    `marks_scored` INT NULL DEFAULT NULL,
                                                                    PRIMARY KEY (`resp_id`))";
                                                            }
                                                            if (mysqli_query($con, $createQuestionTable)){
                                                                if (mysqli_query($con, $createResponseTable)){
                                                                    $createMarklistTable = "CREATE TABLE examify_exam_".$exam_id."_marklist
                                                                    (
                                                                    `resp_id` INT NOT NULL AUTO_INCREMENT,
                                                                    `stud_id` INT NOT NULL UNIQUE,
                                                                    `mark` INT NULL DEFAULT 0,
                                                                     PRIMARY KEY (`resp_id`)
                                                                    )
                                                                    ";
                                                                    if (mysqli_query($con, $createMarklistTable)){
                                                                        echo "<script>window.location.href = 'exams.php?id=0';</script>";
                                                                    }
                                                                }else{
                                                                    echo "SOME ERROR OCCURED!";
                                                                }
                                                            }
                                                        }
                                                }
                                            ?>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <footer class="footer text-center"> 2020 &copy; Examify brought to you by <a href="http://ajwadjumanpc.github.io" target="_blank">ARMED JUROR</a> </footer>

    </div>
</div>

<script src="includes/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<script src="includes/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="includes/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<script src="includes/js/jquery.slimscroll.js"></script>
<script src="includes/js/waves.js"></script>
<script src="includes/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
<script src="includes/plugins/bower_components/counterup/jquery.counterup.min.js"></script>
<script src="includes/plugins/bower_components/chartist-js/dist/chartist.min.js"></script>
<script src="includes/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
<script src="includes/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="includes/js/custom.min.js"></script>
<script src="includes/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
</body>

</html>
