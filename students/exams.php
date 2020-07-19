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
                                    <th>MARKS</th>
                                    <th>STATUS</th>
                                    <th>OPERATIONS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                //Displaying Exams
                                $exam_object = mysqli_query($con, "SELECT * FROM examify_exams WHERE tut_id='$tut_id' ORDER BY deadline DESC");
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
                                            <td><?php echo $exam['marks']; ?></td>
                                            <td><?php if ($exam['completed'] == 0) echo "OPEN";else echo "CLOSED";?></td>
                                            <td>
                                                <a href="<?php echo 'exams_single.php?id=1&&eid='.$exam['eid'];?>">VIEW</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                        <?php
                                        $i = $i+1;
                                    }
                                }
                                ?>
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
