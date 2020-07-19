<?php
//Basic Setups
include '../includes/setup/setup.php';
include 'session.php';
$query=mysqli_query($con, "SELECT * from examify_students where sid='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);
$stud_id = $user['sid'];
$tut_id = $user['tut_id'];
$sql = mysqli_query($con, 'SELECT * FROM examify_portal WHERE id=2');
$portal = mysqli_fetch_array($sql);
if (isset($_GET['eid'])){
    $exam_id = $_GET['eid'];
    $exam = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM examify_exams WHERE eid='$exam_id'"));
}
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
                    <h4 class="page-title">My Exam </h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php?id=0">Dashboard</a></li>
                        <li><a href="exams.php?id=0">Exams</a></li>
                        <li class="active">My Exam</li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <!-- .row -->
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="white-box">
                        <div class="user-bg"> <img width="100%" alt="user" src="includes/plugins/images/large/img1.jpg">
                            <div class="overlay-box">
                                <div class="user-content">
                                    <h1 class="text-white"><?php echo $exam['topic'];?></h1>
                                    <h3 class="text-white">EXAM ID : <?php echo $exam['eid'];?></h3>
                                    <h4 class="text-white">TYPE : <?php echo strtoupper($exam['type']);?></h4>
                                    <h3 class="text-white">DEADLINE : <?php echo $exam['deadline'];?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="user-btm-box">
                            <div class="row">

                            </div>
                            <div class="row" style="padding-top: 20px;">
                                <div class="col-md-6">
                                    <h3 class="timeline-title">QUESTION COUNT</h3>
                                    <h2><?php echo $exam['question_count'];?></h2>
                                </div>
                                <div class="col-md-6">
                                    <h3 class="timeline-title">TOTAL MARKS</h3>
                                    <h2><?php echo $exam['marks'];?></h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h1>INSTRUCTIONS</h1>
                                    <p class="text-info"><pre><?php echo $exam['instructions'];?></pre></p>
                                    <?php
                                    $r_table = "examify_exam_".$exam_id."_responses";
                                    if ($attempted = mysqli_query($con, "SELECT * FROM $r_table WHERE stud_id='$stud_id'")){
                                        if ($exam['completed'] || $attempted->num_rows){
                                            if ($exam['completed']){
                                                echo '<h1 class="box-title">This exam is closed!</h1>';
                                            }else{
                                                echo '<h1 class="box-title">You have attempted this exam once</h1>';
                                            }
                                        }else{
                                            echo '<a href="exams/exams_examination.php?id=1&eid='.$exam_id.'&load=LOAD&qid=1"><button class="col-md-12 btn btn-primary btn-group-justified">ATTEMPT</button></a>';
                                        }
                                    }else{
                                        echo $con->error;
                                    }

                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">TOP PERFORMERS</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>MARK</th>
                                    <th>RANK</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $m_table = "examify_exam_".$exam_id."_marklist";
                                $performers_list = mysqli_query($con, "SELECT * FROM $m_table ORDER BY mark DESC");
                                $performers_count = $performers_list->num_rows;
                                if($performers_count){
                                    $i = 1;
                                    while ($performer = mysqli_fetch_array($performers_list)){
                                        $performer_id = $performer['stud_id'];
                                        $performer_details = mysqli_fetch_array(mysqli_query(
                                                $con, "SELECT * FROM examify_students WHERE sid='$performer_id'"
                                        ));

                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $performer_details['name']; ?></td>
                                            <td><?php echo $performer['mark']; ?></td>
                                            <td><?php echo $i; ?></td>

                                        </tr>
                                        <?php
                                        $i = $i+1;
                                    }
                                }else{
                                    echo '<tr><td colspan="5" class="text-center">NO STUDENT ATTEMPTED YET</td></tr>';
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
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
<script>
    function togglePassword() {
        const pass = document.getElementById('pass');
        if (pass.type === 'password'){
            pass.type = 'text';
        }else {
            pass.type = 'password';
        }
    }
</script>
</body>

</html>
