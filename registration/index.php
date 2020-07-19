<?php
include "setup.php";
if ($_GET['id']==1){
    $name = $_GET['name'];
    $email = $_GET['email'];
    $mobile = $_GET['mobile'];
    $gender = $_GET['gender'];
    $course = $_GET['course'];
    $coupon = $_GET['coupon'];
    if (!mysqli_query($con, "SELECT id FROM curies_students WHERE email='$email'")->num_rows){
        if (mysqli_query($con, "INSERT INTO curies_students (name, email, mobile, course, gender, coupon) VALUES ('$name', '$email', '$mobile', '$course', '$gender', '$coupon');")){
            header('location: status.php?id=1');
        }
    }else{
        echo "<script>alert('This email is already registered once!')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Curies Online Registration">

    <!-- Title Page-->
    <title>Register | Curies Online</title>

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
                    <h2 class="title">Get Started with Curies Online</h2>
                    <form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <input type="number" name="id" value="1" hidden>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label" for="name">name*</label>
                                    <input class="input--style-4" required type="text" id="name" name="name">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label" for="email">email*</label>
                                    <input class="input--style-4" required type="email" id="email" name="email">
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label" for="mobile">Mobile*</label>
                                    <div class="input-group-icon">
                                        <input class="input--style-4" required type="text" id="mobile" name="mobile">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Gender*</label>
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-45" for="male">Male
                                            <input type="radio" required value="M" id="male" name="gender">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container" for="female">Female
                                            <input type="radio" required value="F" id="female"  name="gender">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Course*</label>
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select name="course" required>
                                            <option value="" selected="selected">---Select your course---</option>
                                            <option value="11">Class 11</option>
                                            <option value="12">Class 12</option>
                                            <option value="trial">Trial</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                <label class="label" for="coupon">Coupon Code</label>
                                <div class="input-group-icon">
                                    <input class="input--style-4" type="text" id="coupon" name="coupon">
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row row-space">
                            <div class="col-4"><button class="btn btn--radius-2 btn--blue" type="submit">Register</button></div>
                        </div>
                    </form>
                    <div class="row row-space">
                        <div class="col-4">
                            Already registered? <a href="status.php?id=1" class="text-purple text-decoration-none">Check your enrollment status</a>
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

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->