<?php
include 'setup.php';

$email = $_POST['email'];
$statusCheck = mysqli_query($con, "SELECT * FROM curies_students WHERE email='$email';");
if ($statusCheck->num_rows){
    $status = mysqli_fetch_array($statusCheck);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Curies Online Registration">

    <!-- Title Page-->
    <title>Status | Curies Online</title>

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
                <h1 style="color: deeppink;"><?php echo $status['status'];?></h1>
                <h3>Name : <?php echo $status['name'];?></h3>
                <h3>Mobile : <?php echo $status['mobile'];?></h3>
                <h3>Email : <?php echo $status['email'];?></h3>
                <div class="row row-space">
                    <div class="col-4">
                        <a href="tel:+919633082629" style="color: deeppink;text-decoration: none;font-size: 1.2em">Call Curie Admin</a>
                    </div>
                </div>
                <div class="row row-space">
                    <div class="col-4">
                        <a href="index.php?id=0" class="text-purple text-decoration-none">Go Back to Curies Online</a>
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

<?php
}else {
    echo $con->error;
}

?>