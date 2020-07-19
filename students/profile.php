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
                    <h4 class="page-title">Profile page</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php?id=0">Dashboard</a></li>
                        <li class="active">Profile Page</li>
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
                                    <h1 class="text-white"><?php echo $user['name'];?></h1>
                                    <h2 class="text-white">USERNAME : <?php echo $user['username'];?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="user-btm-box">
                            <div class="col-md-12 col-sm-12 text-center">
                                Email : <?php echo $user['email'];?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12">
                    <div class="white-box">
                        <form class="form-horizontal form-material" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                            <div class="form-group">
                                <label for="name" class="col-md-12">Name *</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="Name" name="name" id="name" required value="<?php echo $user['name'];?>"
                                           class="form-control form-control-line"> </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-md-12">Email *</label>
                                <div class="col-md-12">
                                    <input type="email" placeholder="Email" required value="<?php echo $user['email'];?>"
                                           class="form-control form-control-line" name="email"
                                           id="email"> </div>
                            </div>
                            <div class="form-group">
                                <label for="pass" class="col-md-12">Password</label>
                                <div class="col-md-12">
                                    <input type="password" placeholder="Password" name="pass" id="pass" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="checkbox" name="toggle" id="toggle" onclick="togglePassword()">
                                    <label for="toggle">SHOW PASSWORD</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success" type="submit" name="update">Update Profile</button>
                                </div>
                            </div>
                        </form>
                        <?php
                        if (isset($_POST['update'])){
                            $profileUser  = $user['sid'];
                            $name = $_POST['name'];
                            $email = $_POST['email'];
                            $pass = trim($_POST['pass']);
                            if (empty($pass)){
                                $sql = "UPDATE examify_students SET name='$name', email='$email' WHERE sid='$profileUser'";
                            }else{
                                $password = password_hash($pass, PASSWORD_DEFAULT);
                                $sql = "UPDATE examify_students SET name='$name', email='$email', password='$password' WHERE sid='$profileUser'";
                            }
                            if (mysqli_query($con, $sql)){
                                echo "<script>window.location.href='profile.php'</script>";
                            }else{
                                echo $sql;
                                echo $con->error;
                            }
                        }
                        ?>
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
