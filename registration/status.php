<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Curies Online Registration">

    <!-- Title Page-->
    <title>Check Status | Curies Online</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">

    <!--  Browser Icon  -->
    <link rel="icon" href="../includes/images/logo.png">
</head>

<body>
<div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
    <div class="wrapper wrapper--w680">
        <div class="card card-4">
            <div class="card-body">
                <?php
                if ($_GET['id']==1)
                {
                    echo '<div class="row row-space">
<div class="col-4"><h2 class="title" style="color: green;">Your application submitted.</h2></div>
</div>';
                }
                ?>
                <h2 class="title">Check Your Enrollment Status | Curies Online</h2>
                <form method="POST" action="checkStatus.php">
                    <div class="row row-space">
                        <div class="col-4">
                            <div class="input-group">
                                <label class="label" for="email">email*</label>
                                <input class="input--style-4" required type="email" id="email" name="email">
                            </div>
                        </div>
                    </div>
                    <div class="row row-space">
                        <div class="col-4"><button class="btn btn--radius-2 btn--blue" type="submit" onclick="checkStatus()">Check</button></div>
                    </div>
                </form>
                <div class="row row-space">
                    <div class="col-4">
                        New to Curies?  <a href="index.php?id=0" class="text-purple text-decoration-none">Get started with Curies Online</a>
                    </div>
                </div>
                <div class="row row-space">
                    <div class="col-4" id="result">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jquery JS-->
<script src="vendor/jquery/jquery.min.js"></script>
<!-- Vendor JS-->
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/datepicker/moment.min.js"></script>
<script src="vendor/datepicker/daterangepicker.js"></script>

<!-- Main JS-->
<script src="js/global.js"></script>


</body>

</html>
<!-- end document-->