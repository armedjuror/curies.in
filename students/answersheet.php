<?php
//Basic Setups
include '../includes/setup/setup.php';
include '../includes/setup/session.php';
$query=mysqli_query($con, "SELECT * from examify_students where sid='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);
$stud_id = $user['sid'];
$tut_id = $user['tut_id'];
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
    <link rel="stylesheet" href="includes/css/answer.css">
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
                        <li><a href="dashboard.php?id=0">Exams</a></li>
                        <li class="active">Answer Sheet</li>
                    </ol>
                </div>
            </div>
            <!--Your Exams-->
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title">Select your Exam</h3>
                        <form class="form-horizontal form-material" action="#" method="post">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <select id="examSelect" required name="examSelect" class="form-control form-control-line form-group" onchange="loadExam()">
                                           <option value="">--SELECT YOUR EXAM--</option>
                                        <?php
                                            $exam_object = mysqli_query($con, "SELECT * FROM examify_exams WHERE tut_id =$tut_id AND completed=1");
                                            $exam_count = $exam_object->num_rows;
                                            for($i=0; $i<$exam_count; $i++){
                                                $exam_ = mysqli_fetch_array($exam_object);
                                                echo '<option value="'.$exam_['eid'].'">'.$exam_['topic'].'-'.$exam_['eid'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="white-box" id="answerSheet">
                        <h1 class="h1 text-center">Please Select an Exam</h1>
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
<script src="ajax.js"></script>
<script>
    function reportQuestion() {
        let report = new XMLHttpRequest()
        let url = "reportQuestion.php"
        let exam_id = document.getElementById('exam').value
        let q_id = parseInt(document.getElementById('questionnumber').value)
        let problem = document.getElementById('problem').value
        if (!q_id){
            alert("Please select a question number")
            return false
        }else if(!problem){
            alert("Please specify your problem!")
            return false
        }else {
            document.getElementById('submit').setAttribute('data-dismiss',"modal" )
            let varList = "exam_id=" + exam_id + "&qid=" + q_id + "&prob=" + problem
            report.open('POST', url, true)
            report.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
            report.onreadystatechange = function () {
                if (report.readyState === 4 && report.status === 200) {
                    document.getElementById('model').innerHTML = report.responseText
                    loadQuestion(q_id)
                    return true
                }
            }
            report.send(varList)
            document.getElementById('model').innerHTML = '<h1 class="text-center font-weight-bold">Reporting Question...</h1>'
        }
    }

</script>
</body>

</html>

