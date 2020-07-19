<?php
include '../includes/setup/setup.php';
include 'session.php';
$preview_query=mysqli_query($con, "SELECT * from examify_tutors where id='$session_id'")or header('location:login.php?id=0');
$user=mysqli_fetch_array($preview_query);
$sql = mysqli_query($con, 'SELECT * FROM examify_portal WHERE id=2');
$portal = mysqli_fetch_array($sql);
$tut_id = $user['id'];
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

<!--    Navigation-->
    <?php include "navigation.php"; ?>

    <!--Page Content-->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">My Students</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php?id=0">Dashboard</a></li>
                        <li class="active">My Students</li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <!-- .row -->
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="white-box">
                        <?php
                        if ($_GET['id']==0){
                            ?>
                            <h3 class="box-title">REGISTER A STUDENT</h3>
                            <form class="form-horizontal form-material" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                                <div class="form-group">
                                    <label for="uname" class="col-md-12">Username *</label>
                                    <div class="col-md-12">
                                        <input type="text" name="uname" id="uname" required value="<?php echo mt_rand();?>"
                                               class="form-control form-control-line"> </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-md-12">Name *</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Name" name="name" id="name" required
                                               class="form-control form-control-line"> </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-md-12">Email </label>
                                    <div class="col-md-12">
                                        <input type="email" placeholder="Email"
                                               class="form-control form-control-line" name="email"
                                               id="email"> </div>
                                </div>
                                <div class="form-group">
                                    <label for="pass" class="col-md-12">Password</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Password" value="<?php echo mt_rand();?>" name="pass" id="pass" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="checkbox" checked name="toggle" id="toggle" onclick="togglePassword()">
                                        <label for="toggle">SHOW PASSWORD</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success" type="submit" name="register">REGISTER</button>
                                    </div>
                                </div>
                            </form>
                            <?php
                        }elseif ($_GET['id']==1){
                            $student_username = $_GET['sid'];
                            $student_edit = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM examify_students WHERE username='$student_username'"))
                            ?>
                            <h3 class="box-title">EDIT STUDENT DETAILS</h3>
                            <form class="form-horizontal form-material" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                                <div class="form-group">
                                    <label for="uname" class="col-md-12">Username *</label>
                                    <div class="col-md-12">
                                        <input type="text" name="uname" id="uname" required value="<?php echo $student_edit['username'];?>" readonly
                                               class="form-control form-control-line"> </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-md-12">Name *</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Name" name="name" id="name" required value="<?php echo $student_edit['name'];?>"
                                               class="form-control form-control-line"> </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-md-12">Email </label>
                                    <div class="col-md-12">
                                        <input type="email" placeholder="Email" value="<?php echo $student_edit['email'];?>"
                                               class="form-control form-control-line" name="email"
                                               id="email"> </div>
                                </div>
                                <div class="form-group">
                                    <label for="pass" class="col-md-12" title="Change only if needed">New Password</label>
                                    <div class="col-md-12">
                                        <input type="password" title="Change only if needed" placeholder="New Password" name="pass" id="pass" class="form-control form-control-line">
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
                                        <button class="btn btn-success" type="submit" name="update">UPDATE</button>
                                    </div>
                                </div>
                            </form>
                            <?php
                        }elseif ($_GET['id']==2){
                            $student_username = $_GET['sid'];
                            echo "<script>alert('This will delete student with id".$student_username."Are you sure? If you don\'t want to delete, refresh the page' )</script>";
                            $deleteStudent = "DELETE FROM examify_students WHERE username='$student_username'";
                            if (mysqli_query($con, $deleteStudent)){
                                echo '
                                    <script>
                                    alert("Student with username = '.$student_username.' deleted successfully");
                                    window.location.href="students.php?id=0";
                                    </script>
                                    ';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Students</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Score</th>
                                    <th>Operations</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $students_list = mysqli_query($con,'SELECT * FROM examify_students WHERE tut_id='.$tut_id.' ORDER BY score DESC');
                                $std_count = $students_list->num_rows;
                                if ($std_count){
                                    $i = 1;
                                    while ($student = mysqli_fetch_array($students_list)){
                                        $s_uname = $student['username'];
                                        $s_name = $student['name'];
                                        $score = $student['score'];
                                        echo "
                                            <tr>
                                                <td>$i</td>
                                                <td>$s_uname</td>
                                                <td>$s_name</td>
                                                <td>$score</td>
                                                <td>
                                                    <a href='students.php?id=1&sid=$s_uname'>EDIT</a> | 
                                                    <a href='students.php?id=2&sid=$s_uname'>DELETE</a>
                                                </td>
                                            </tr>
                                            ";
                                        $i+=1;
                                    }
                                }else{
                                    echo "<tr><td colspan='4' style='text-align: center'>No Student Added Yet!</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
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
<?php
if (isset($_POST['register'])){
    $name = $_POST['name'];
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $pass = trim($_POST['pass']);
    $password = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO examify_students (tut_id, name, username, password, email) VALUES ('$tut_id','$name', '$uname', '$password', '$email')";
    if (mysqli_query($con, $sql)){
        echo '
        <script>
        alert("Student Registered with username = '.$uname.' and password = '.$pass.'");
        window.location.href="students.php?id=0";
        </script>
        ';
    }else {
        echo "Some error occured!<br>Error : ".$con->error;

    }
}

if ($_POST['update']){
    $name = $_POST['name'];
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $pass = trim($_POST['pass']);
    if (empty($pass)){
        $sql = "UPDATE examify_students SET 
                            name = '$name',
                            email = '$email'
                            WHERE username='$uname'";
    }else{
        $password = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "UPDATE examify_students SET 
                            name = '$name',
                            email = '$email',
                            password = '$password'
                            WHERE username='$uname'";
    }
    if (mysqli_query($con, $sql)){
        echo '
        <script>
        alert("Student with username = '.$uname.' updated successfully");
        window.location.href="students.php?id=0";
        </script>
        ';
    }else {
        echo "Some error occured!<br>Error : ".$con->error;
    }
}
?>
