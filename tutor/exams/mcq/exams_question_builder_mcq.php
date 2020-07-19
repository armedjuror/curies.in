<?php
include '../../../includes/setup/setup.php';
session_start();
if (!isset($_SESSION['tutor_id']) || (trim($_SESSION['tutor_id']) == '')) {
    header('location: ../../login.php?id=0');
    exit();
}
$session_id=$_SESSION['tutor_id'];
$preview_query=mysqli_query($con, "SELECT * from examify_tutors where id='$session_id'")or die('Session logged out');
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

$user=mysqli_fetch_array($preview_query);
$sql = mysqli_query($con, 'SELECT * FROM examify_portal WHERE id=2');
$portal = mysqli_fetch_array($sql);
$exam_id = $_GET['eid'];
$exam = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM examify_exams WHERE eid='$exam_id'"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="../../includes/plugins/images/favicon.png">
    <title><?php echo $portal['name']; ?> | Examify</title>
    <link href="../../includes/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../includes/plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <link href="../../includes/plugins/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="../../includes/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="../../includes/css/animate.css" rel="stylesheet">
    <link href="../../includes/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../../includes/css/dash.css">
    <link href="../../includes/css/colors/default.css" id="theme" rel="stylesheet">
</head>

<body class="fix-header">
<!--Pre-loader-->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
    </svg>
</div>

<div id="wrapper">
    <!--Page Content-->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">QUESTION Builder</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="../../dashboard.php?id=0">Dashboard</a></li>
                        <li><a href="../../exams.php?id=0">Exams</a></li>
                        <li><a href="<?php echo '../../exams_single.php?id=1&&eid='.$exam_id;?>">Exam Builder</a></li>
                        <li class="active">Question Builder</li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <!-- .row -->
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">QUESTIONS</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>QUESTION</th>
                                    <th>MARK</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $question_list = mysqli_query($con,'SELECT * FROM examify_exam_'.$exam_id.'_questions');
                                $q_count = $question_list->num_rows;
                                $total_mark_till_now = 0;
                                if ($q_count){
                                    while ($question = mysqli_fetch_array($question_list)){
                                        $qid = $question['qid'];
                                        $ques = $question['question'];
                                        $marks = $question['marks'];
                                        echo "
                                            <tr>
                                                <td>$qid</td>
                                                <td>$ques</td>
                                                <td>$marks</td>
                                            </tr>
                                            ";
                                        $total_mark_till_now += $marks;
                                    }
                                }else{
                                    echo "<tr><td colspan='4' style='text-align: center'>No Question Added Yet!</td></tr>";
                                }
                                ?>
                                <tr>
                                    <td colspan="2"><h5 class="text-dark">REMAINING NUMBER OF QUESTIONS : <?php $remaining = (int)$exam['question_count']-(int)$q_count;echo $remaining;?></h5></td>
                                    <td colspan="2"><h5 class="text-dark">TOTAL MARKS : <?php echo $total_mark_till_now;?></h5></td>
                                </tr>
                                <tr>
                                    <?php
                                    $sql = "UPDATE examify_exams SET marks='$total_mark_till_now' WHERE eid='$exam_id'";
                                    if (mysqli_query($con, $sql)){
                                        echo '<td colspan=4>DATA UPDATED SUCCESSFULLY!</td>';
                                    }else{
                                        echo '<td colspan=4>DATA UPDATION PARTIALLY FAILED. IT WILL BE UPDATED ON NEXT RELOAD.</td>';
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <td colspan="3"><a href="<?php echo '../../exams_single.php?id=1&&eid='.$exam_id;?>"><button class="btn btn-group-justified btn-info">GO BACK</button></a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12">
                    <div class="white-box">
                        <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                                <select class="form-control pull-right row b-none" name="qid" required>
                                    <?php
                                    $total_questions = (int)$exam['question_count'];
                                    echo "<option value=''>--SELECT QUESTION--</option>";
                                    for ($i=1; $i<=$total_questions; $i+=1){
                                        echo "<option value='".$i."'>Question-".$i."</option>";
                                    }
                                    ?>
                                </select>
                                <input type="number" name="id" value="1" hidden>
                                <input type="text" name="eid" value="<?php echo $exam_id; ?>" hidden>
                                <input  class="btn-primary btn btn-group-justified row pull-right b-none" type="submit" value="LOAD" name="load">
                            </form>
                        </div>
                        <?php
                            if (isset($_GET['load'])){
                                $question_id = $_GET['qid'];
                                if (empty($question_id)){
                                    $question_id = 1;
                                }
                                $tableName = 'examify_exam_'.$exam_id.'_questions';
                                $question_object = mysqli_query($con ,"SELECT * FROM ".$tableName." WHERE qid='$question_id' ");
                                $question_details = mysqli_fetch_array($question_object);
                                if ($question_object->num_rows){
                                    //Edit Question
                                    ?>
                                    <form class="form-horizontal form-material" action="<?php echo 'exams_question_edit_mcq.php?id=3&&eid='.$exam_id.'&qid='.$question_id; ?>" method="post" enctype="multipart/form-data">
                                            <label class="box-label">QUESTION-<?php echo $question_id; ?></label>
                                            <div class="form-group">
                                                <label class="col-md-12" for="ques">Question</label>
                                                <div class="col-md-12">
                                                    <input required type="text" placeholder="Question" value="<?php echo $question_details['question'];?>"
                                                           class="form-control form-control-line" name="ques" id="ques">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6" for="q-img">Question Add-On Images</label>
                                                <div class="col-md-6">
                                                    <input type="file" class="form-control form-control-line" name="q-img" id="q-img" accept="image/jpeg, image/png">
                                                </div>
                                                <label class="col-md-6" for="mark">Mark</label>
                                                <div class="col-md-6">
                                                    <input type="number" required class="form-control form-control-line" value="<?php echo $question_details['marks'];?>" placeholder="MARK" name="mark" id="mark">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3" for="A">Option-A</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control form-control-line" value="<?php echo $question_details['option1'];?>" placeholder="Option-A" name="A" id="A" required>
                                                </div>
                                                <label class="col-md-3" for="B">Option-B</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control form-control-line" value="<?php echo $question_details['option2'];?>" placeholder="Option-B" name="B" id="B" required>
                                                </div>
                                                <label class="col-md-3" for="C">Option-C</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control form-control-line" value="<?php echo $question_details['option3'];?>" placeholder="Option-C" name="C" id="C" required>
                                                </div>
                                                <label class="col-md-3" for="D">Option-D</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control form-control-line" value="<?php echo $question_details['option4'];?>" placeholder="Option-D" name="D" id="D" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6" for="ans">Answer</label>
                                                <div class="col-md-6">
                                                    <SELECT class="form-control form-control-line" name="ans" id="ans" required>
                                                        <?php
                                                        $answerOption = $question_details['answer'];
                                                        function optionSelect($optionValue, $value){
                                                            if ($optionValue==$value){
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?>
                                                        <option value="">--ANSWER--</option>
                                                        <option value="A" <?php optionSelect('A', $answerOption); ?>>A</option>
                                                        <option value="B" <?php optionSelect('B', $answerOption); ?>>B</option>
                                                        <option value="C" <?php optionSelect('C', $answerOption); ?>>C</option>
                                                        <option value="D" <?php optionSelect('D', $answerOption); ?>>D</option>
                                                    </SELECT>
                                                </div>
                                                <label class="col-md-6" for="ans-img">Answer Add-on Images</label>
                                                <div class="col-md-6">
                                                    <input type="file" class="form-control form-control-line" name="ans-img" id="ans-img" accept="image/jpeg, image/png">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input type="submit" name="save" value="SAVE QUESTION" class="btn btn-group-justified btn-success">
                                                </div>
                                            </div>
                                        </form>
                                    <div class="col-md-12">
                                        <a href="<?php echo 'exams_question_clear_mcq.php?id=4&eid='.$exam_id.'&qid='.$question_id;?>"><button name="reset" value="CLEAR QUESTION" class="btn btn-group-justified btn-danger">CLEAR QUESTION</button></a>
                                    </div>
                                    <?php
                                }else{
                                    //Create Question
                                    ?>
                                    <form class="form-horizontal form-material" action="<?php echo 'exams_question_create_mcq.php?id=2&&eid='.$exam_id.'&qid='.$question_id; ?>" method="post" enctype="multipart/form-data">
                                            <label class="box-label">QUESTION-<?php echo $question_id; ?></label>
                                            <div class="form-group">
                                                <label class="col-md-12" for="ques">Question</label>
                                                <div class="col-md-12">
                                                    <input required type="text" placeholder="Question"
                                                           class="form-control form-control-line" name="ques" id="ques">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6" for="q-img">Question Add-On Images</label>
                                                <div class="col-md-6">
                                                    <input type="file" class="form-control form-control-line" name="q-img" id="q-img" accept="image/jpeg, image/png">
                                                </div>
                                                <label class="col-md-6" for="mark">Mark</label>
                                                <div class="col-md-6">
                                                    <input type="number" required class="form-control form-control-line" placeholder="MARK" name="mark" id="mark">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3" for="A">Option-A</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control form-control-line" placeholder="Option-A" name="A" id="A" required>
                                                </div>
                                                <label class="col-md-3" for="B">Option-B</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control form-control-line" placeholder="Option-B" name="B" id="B" required>
                                                </div>
                                                <label class="col-md-3" for="C">Option-C</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control form-control-line" placeholder="Option-C" name="C" id="C" required>
                                                </div>
                                                <label class="col-md-3" for="D">Option-D</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control form-control-line" placeholder="Option-D" name="D" id="D" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6" for="ans">Answer</label>
                                                <div class="col-md-6">
                                                    <SELECT class="form-control form-control-line" name="ans" id="ans" required>
                                                        <option value="">--ANSWER--</option>
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="D">D</option>
                                                    </SELECT>
                                                </div>
                                                <label class="col-md-6" for="ans-img">Answer Add-on Images</label>
                                                <div class="col-md-6">
                                                    <input type="file" class="form-control form-control-line" name="ans-img" id="ans-img" accept="image/jpeg, image/png">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input type="submit" name="create" value="CREATE QUESTION" class="btn btn-group-justified btn-success">
                                                </div>
                                            </div>
                                        </form>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
<!--            Preview-->
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">PREVIEW</h3>
                        <?php
                        if (isset($_GET['load'])){
                            $question_id = $_GET['qid'];
                            if (empty($question_id)){
                                $question_id = 1;
                            }
                            $tableName = 'examify_exam_'.$exam_id.'_questions';
                            $preview_object = mysqli_query($con, "SELECT * FROM $tableName WHERE qid='$question_id'");
                            if ($preview_object->num_rows){
                                $preview = mysqli_fetch_array($preview_object);
                                ?>
                                <form action="#" class="form-horizontal form-material">
                                    <h3 class="text-dark">QUESTION-<?php echo $question_details['qid'];?></h3>
                                    <div class="form-group">
                                        <h3><?php echo $question_details['question'];?></h3><img src="" alt="" class="img">
                                        <?php if (!empty($preview['question_adds'])){
                                            echo '<img class="img img-responsive q_img" alt="img" src="data:image/jpeg;base64,'.base64_encode($preview['question_adds']).'">';
                                        } ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="option1" class="col-md-3 col-sm-6">A:<?php echo $question_details['option1'];?></label>
                                            <div class="col-md-3 col-sm-6">
                                                <input type="radio" name="answer" id="option1" value="<?php echo $question_details['option1'];?>" class="form-control radio">
                                            </div>
                                            <label for="option2" class="col-md-3 col-sm-6">B:<?php echo $question_details['option2'];?></label>
                                            <div class="col-md-3 col-sm-6">
                                                <input type="radio" name="answer" id="option2" value="<?php echo $question_details['option2'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="option3" class="col-md-3 col-sm-6">C:<?php echo $question_details['option3'];?></label>
                                            <div class="col-md-3 col-sm-6">
                                                <input type="radio" name="answer" id="option3" value="<?php echo $question_details['option3'];?>" class="form-control">
                                            </div>
                                            <label for="option4" class="col-md-3 col-sm-6">D:<?php echo $question_details['option4'];?></label>
                                            <div class="col-md-3 col-sm-6">
                                                <input type="radio" name="answer" id="option4" value="<?php echo $question_details['option4'];?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-info">PREVIOUS</button>
                                        <input type="reset" value="RESET" class="btn btn-danger">
                                        <input type="submit" value="SAVE" class="btn btn-success  pull-right">
                                        <button class="btn btn-info pull-right">NEXT</button>
                                    </div>
                                </form>
                                <?php
                            }else{
                                echo '<h2>This question is not registered yet. So no preview can be generated.</h2>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center"> 2020 &copy; Examify brought to you by <a href="http://ajwadjumanpc.github.io" target="_blank">ARMED JUROR</a> </footer>

    </div>
</div>

<script src="../../includes/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../includes/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../includes/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<script src="../../includes/js/jquery.slimscroll.js"></script>
<script src="../../includes/js/waves.js"></script>
<script src="../../includes/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
<script src="../../includes/plugins/bower_components/counterup/jquery.counterup.min.js"></script>
<script src="../../includes/plugins/bower_components/chartist-js/dist/chartist.min.js"></script>
<script src="../../includes/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
<script src="../../includes/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="../../includes/js/custom.min.js"></script>
<script src="../../includes/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
</body>

</html>

