<?php
include '../includes/setup/setup.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title><?php echo $portal['name']; ?> | Examify</title>
    <link href="includes/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="includes/plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <link href="includes/plugins/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="includes/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="includes/css/animate.css" rel="stylesheet">
    <link href="includes/css/style.css" rel="stylesheet">
    <link href="includes/css/colors/default.css" id="theme" rel="stylesheet">
</head>

<body class="fix-header">
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header">
            <div class="top-left-part">
                <a class="logo" href="dashboard.php">
                            <span class="hidden-xs">
                                <h1 class="dark-logo">Examify</h1>
                                <h1 class="light-logo">Examify</h1>
                            </span>
                </a>
            </div>
            <ul class="nav navbar-top-links navbar-right pull-right">
                <li>
                    <a class="nav-toggler open-close waves-effect waves-light hidden-md hidden-lg" href="javascript:void(0)"><i class="fa fa-bars"></i></a>
                </li>
                <li>
                    <a class="profile-pic" href="profile.php">
                        <i class="fa fa-user fa-2x"></i>
                        <b class="hidden-xs"><?php echo $user['name']; ?> | <?php echo $portal['name']; ?></b>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav slimscrollsidebar">
            <div class="sidebar-head">
                <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3>
            </div>
            <ul class="nav" id="side-menu">
                <li style="padding: 70px 0 0;">
                    <a href="dashboard.php?id=0" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>Dashboard</a>
                </li>
                <li>
                    <a href="profile.php?id=0" class="waves-effect"><i class="fa fa-user fa-fw" aria-hidden="true"></i>Profile</a>
                </li>
                <li>
                    <a href="exams.php?id=0" class="waves-effect"><i class="fa fa-pencil-square fa-fw" aria-hidden="true"></i>My Exams</a>
                </li>
                <li>
                    <a href="answersheet.php" class="waves-effect"><i class="fa fa-print fa-fw" aria-hidden="true"></i>Answer Sheet</a>
                </li>
<!--                <li>-->
<!--                    <a href="results.php" class="waves-effect"><i class="fa fa-trophy fa-fw" aria-hidden="true"></i>Final Results</a>-->
<!--                </li>-->
                <li>
                    <a href="logout.php" class="waves-effect"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>Log Out</a>
                </li>

            </ul>
        </div>
    </div>
</body>
</html>
