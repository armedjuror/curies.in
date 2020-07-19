<?php
include "../includes/setup/setup.php";
include "../includes/setup/session.php";

if($_GET['id']){
    $id = $_GET['id'];
    $sql = mysqli_query($con, "SELECT * FROM examify_tutors WHERE id = $id");
    $tutor = mysqli_fetch_array($sql);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="../includes/images/logo.png" type="image/x-icon">
    <title>Examify | Tutor Profile</title>
    <link rel="stylesheet" href="../includes/styles/admin/tutor_reg.css">
</head>
<body>
    <?php include "navigation.html";?>
    <div class="wrapper">
        <div class="card">
            <div class="row">
                <?php
                if ($tutor['profilepic']){
                    echo '<img class="profile" alt="user-img" src="data:image/jpeg;base64,'.base64_encode($tutor['profilepic']).'">';
                }else{
                    echo '<i class="fa fa-user fa-2x"></i>';
                }
                ?>
                <h1><?php echo $tutor['name']; ?></h1>
            </div>


            <p><?php echo $tutor['bio']; ?></p>
            <p>EMAIL : <a href="<?php echo "mailto:".$tutor['email']; ?>" target="_blank"><?php echo $tutor['email']; ?></p>
        </div>
    </div>
</body>
</html>