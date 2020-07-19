<?php
//Basic Setups
include '../includes/setup/setup.php';
include 'session.php';
$query=mysqli_query($con, "SELECT * from examify_students where sid='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);
$stud_id = $user['sid'];
$tut_id = $user['tut_id'];
$my_tutor = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM examify_tutors WHERE id=".$tut_id));
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

        <!--Navigation Bar-->
        <?php include "navigation.php"; ?>

        <!--Page Content-->
        <div id="page-wrapper">
            <div class="container-fluid">
                <!--Page title-->
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4></div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                        </ol>
                    </div>
                </div>

                <!--Overview Cards-->
                <div class="row">
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Your Overall Score</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success">
                                        <?php
                                        echo $user['score'];
                                        ?>
                                    </span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Your Exams</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash3"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info">
                                        <?php
                                        $exam_object = mysqli_query($con, "SELECT * FROM examify_exams WHERE tut_id='$tut_id'");
                                        $my_count = $exam_object->num_rows;
                                        echo $my_count;
                                        ?>
                                    </span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Exams Attended</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash2"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-purple"></i><span class="counter text-purple">
                                        <?php
                                        $count = 0;
                                        while ($exam = mysqli_fetch_array($exam_object)){
                                            $exam_id = $exam['eid'];
                                            $r_table = 'examify_exam_'.$exam_id.'_responses';
                                            $response = mysqli_query($con,"SELECT * FROM ".$r_table." WHERE stud_id = '$stud_id'");
                                            if ($response->num_rows){
                                                $count+=1;
                                            }
                                        }
                                        echo $count;
                                        ?>
                                    </span></li>
                            </ul>
                        </div>
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
                                                    <a href="<?php echo 'exams_single.php?id=1&&eid='.$exam['eid'];?>">VIEW</a>&nbsp;
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
                <!--Announcement-->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Announcements</h3>
                            <div class="comment-center p-t-10">
                                    <?php
                                        $announce = mysqli_query($con, "SELECT * FROM examify_announcements");
                                        if ($announce->num_rows){
                                            while($row = mysqli_fetch_array($announce)){
                                                $announcer_id = $row['announcer'];
                                                $announcer = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM examify_tutors WHERE id=$announcer_id"));
                                            ?>
                                <div class="comment-body">
                                            <div class="user-img">
                                                <?php
                                                if ($announcer['profilepic']){
                                                    echo '<img class="img-circle" style="width:50px;height:50px;" alt="img" src="data:image/jpeg;base64,'.base64_encode($announcer['profilepic']).'">';
                                                }else{
                                                    echo '<i class="fa fa-user fa-2x"></i>';
                                                }
                                                ?>
                                            <div class="mail-contnet">
                                                <h5><?php echo $announcer['name']; ?></h5>
                                                <span class="text-info">to <?php echo strtoupper($row['audience']); ?></span><br>
                                                <span class="time"><?php echo $row['timestamp']; ?></span>
                                                <br/><span class="mail-desc"><?php echo $row['announcement']; ?></span>
                                            </div>
                                </div>
                                            <?php
                                            }
                                        }else{
                                            ?>
                                            <div class="comment-body">
                                                <div class="mail-contnet">
                                                    <span class="mail-desc">NO ANNOUNCEMENTS YET!</span>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">   
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            LEADER BOARD
                                        </div>
                                        <div class="panel-body">
                                            <ul class="chatonline">
                                            <?php
                                            $students = mysqli_query($con, "SELECT * FROM examify_students ORDER BY score DESC");
                                            $students_count = $students->num_rows;
                                            if ($students_count){
                                                $i = 1;
                                                while ($leader = mysqli_fetch_array($students)){
                                                   ?>
                                                    <li>
                                                        <a href="javascript:void(0)"><i class="fa fa-2x  fa-hand-o-right"></i>
                                                                <b class="text-success"><?php echo $i;?></b>&nbsp;&nbsp;&nbsp;
                                                                <span>
                                                                    <?php echo $leader['name'];?>
                                                                    <i class="text-info">
                                                                        Student of
                                                                        <?php
                                                                        $tut_id = $leader['tut_id'];
                                                                        $tutor = mysqli_fetch_array(mysqli_query($con, "SELECT `name` FROM examify_tutors WHERE id=$tut_id"))['name'];
                                                                        echo $tutor;
                                                                        ?>
                                                                    </i>
                                                                </span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                    if ($i>=5){
                                                        break;
                                                    }
                                                    $i = $i+1;
                                                }
                                            }else{
                                                ?>
                                                <a href="#"><span>NO STUDENT IN THE LEADER BOARD</span></a>
                                                <?php
                                            }
                                            ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                    <div class="white-box">
                        <div class="user-bg"> <img width="100%" alt="user" src="includes/plugins/images/large/img1.jpg">
                            <div class="overlay-box">
                                <div class="user-content">
                                    <a href="javascript:void(0)"><img src="<?php echo 'data:image/jpeg;base64,'.base64_encode($my_tutor['profilepic']); ?>"
                                                                      class="thumb-lg img-circle" alt="img"></a>
                                    <h2 class="text-white h2">YOUR CLASS : <?php echo $my_tutor['name'];?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="user-btm-box">
                            <div class="col-md-12 col-sm-12 text-justify">
                                <h3 class="text-dark">EMAIL : <?php echo $my_tutor['email'];?></h3>
                                <?php echo $my_tutor['bio'];?>
                            </div>
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
