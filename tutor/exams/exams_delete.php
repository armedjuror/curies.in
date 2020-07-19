<?php
include '../../includes/setup/setup.php';
session_start();
if (!isset($_SESSION['tutor_id']) || (trim($_SESSION['tutor_id']) == '')) {
    header('location: ../login.php?id=0');
    exit();
}
$session_id=$_SESSION['tutor_id'];
$query=mysqli_query($con, "SELECT * from examify_tutors where id='$session_id'")or die('Session logged out');
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
        <link rel="icon" type="image/png" sizes="16x16" href="../includes/plugins/images/favicon.png">
        <title><?php echo $portal['name']; ?> | Examify</title>
        <link href="../includes/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../includes/plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
        <link href="../includes/plugins/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
        <link href="../includes/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
        <link href="../includes/css/animate.css" rel="stylesheet">
        <link href="../includes/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="../includes/css/dash.css">
        <link href="../includes/css/colors/default.css" id="theme" rel="stylesheet">
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
                        <h4 class="page-title">Exams</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="../dashboard.php?id=0">Dashboard</a></li>
                            <li><a href="../exams.php">Exams</a></li>
                            <li class="active">Delete/Clear Exam</li>
                        </ol>
                    </div>
                </div>
                <!--Your Exams-->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <?php
                            if ($_GET['id']==0){
                                ?>
                                <h3 class="box-title">Delete Exam</h3>
                                <h3>Are you sure to delete?</h3>
                                <p class="text-danger"> This operation is irreversible! This will delete all data related to this exam including questions and responses.</p>
                                <h4>Following databases will be deleted:</h4>
                                <?php
                                $e_id = $_GET['eid'];
                                echo "<ol>";
                                echo "<li>examify_exam_".$e_id."_questions</li>";
                                echo "<li>examify_exam_".$e_id."_responses</li>";
                                echo "<li>examify_exam_".$e_id."_marklist</li>";
                                echo '</ol>';
                            }elseif ($_GET['id']==1){
                                ?>
                                <h3 class="box-title">Clear Exam</h3>
                                <h3>Are you sure to clear?</h3>
                                <p class="text-danger"> This operation is irreversible! This will delete all responses related to this exam.</p>
                                <h4>Following databases will be cleared:</h4>
                                <?php
                                $e_id = $_GET['eid'];
                                echo "<ol>";
                                echo "<li>examify_exam_".$e_id."_responses</li>";
                                echo "<li>examify_exam_".$e_id."_marklist</li>";
                                echo '</ol>';
                            }
                            ?>

                            <h>Do you want to continue?</h>
                            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
                                <input type="number" value="<?php echo $_GET['id']; ?>" name="id" hidden>
                                <input type="text" value="<?php echo $_GET['eid']; ?>" name="eid" hidden>
                                <a href="../exams.php"><button type="button" class="btn-info">NO</button></a>
                                <input type="submit" name="delete" class="btn-danger" value="YES">
                            </form>
                            <?php
                            if (isset($_GET['delete'])){
                                $e_id = $_GET['eid'];
                                $q_table = "examify_exam_".$e_id."_questions";
                                $r_table = "examify_exam_".$e_id."_responses";
                                $m_table = "examify_exam_".$e_id."_marklist";
                                if ($_GET['id']==0){
                                    $deleteExam = "DELETE FROM examify_exams WHERE eid='$e_id'";
                                    $deleteTables = "DROP TABLE IF EXISTS $q_table, $r_table, $m_table";
                                    if (mysqli_query($con, $deleteTables)){
                                        if (mysqli_query($con, $deleteExam)){
                                            echo "<h3>Exam of id ".$e_id." deleted!</h3>";
                                            echo '<br><a href="../exams.php?id=0">GO BACK</a>';
                                        }else{
                                            echo $con->error;
                                        }
                                    }else{
                                        echo $con->error;
                                    }
                                }elseif ($_GET['id']==1){
                                    $clearExam = "TRUNCATE TABLE $r_table, $m_table";
                                    if (mysqli_query($con, $clearExam)){
                                        echo "<h3>Exam responses of id ".$e_id." cleared!</h3>";
                                        echo '<br><a href="../exams.php?id=0">GO BACK</a>';
                                    }else{
                                        echo $con->error;
                                    }
                                }

                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>

            <footer class="footer text-center"> 2020 &copy; Examify brought to you by <a href="http://ajwadjumanpc.github.io" target="_blank">ARMED JUROR</a> </footer>

        </div>
    </div>

    <script src="../includes/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../includes/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../includes/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <script src="../includes/js/jquery.slimscroll.js"></script>
    <script src="../includes/js/waves.js"></script>
    <script src="../includes/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="../includes/plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <script src="../includes/plugins/bower_components/chartist-js/dist/chartist.min.js"></script>
    <script src="../includes/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../includes/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="../includes/js/custom.min.js"></script>
    <script src="../includes/js/dashboard1.js"></script>
    <script src="../includes/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    </body>

    </html>
<?php
