<?php
include "../includes/setup/setup.php";
include "../includes/setup/session.php";
$query=mysqli_query($con, "SELECT * from examify_admin where id='$session_id'")or die('Session logged out');
$user=mysqli_fetch_array($query);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../includes/styles/admin/tutor_reg.css">
    <link rel="shortcut icon" href="../includes/images/logo.png" type="image/x-icon">
    <title>Examify | System Admin</title>
</head>
<body>
    <?php include "navigation.html";?>
    <div class="wrapper">
        <div class="card">
            <h1>Portal Registration</h1>
            <p>This Registration will customise your portal with the name and details of your organisation</p>
            <form action="<?php echo $_SERVER['PHP_SELF'].'?id=1' ?>" method="post">
                <input type="text" name="name" id="name" placeholder="PORTAL NAME">
                <input type="email" name="email" id="email" placeholder="EMAIL">
                <textarea name="bio" id="bio" placeholder="Describe Your Organisation Briefly"></textarea>
                <input type="submit" value="UPDATE" name="update">
            </form>
        </div>
        <div class="card">
            <h1>Portal Details</h1>
            <?php
            $sql = mysqli_query($con, "SELECT * FROM examify_portal WHERE id=2");
            $portal = mysqli_fetch_array($sql);
            ?>
            <h2>NAME : <?php echo $portal['name']; ?></h2>
            <p>EMAIL : <a href="<?php echo "mailto:".$portal['email']; ?>" target="_blank"><?php echo $portal['email']; ?></p>
            <h2>Bio</h2>
            <p><?php echo $portal['bio'];?></p>
        </div>
    </div>
</body>
</html>
<?php
if($_GET['id']){
    $sql = "UPDATE examify_portal SET `name`= ?, email = ?, bio = ? WHERE id=2";
    if($insert = $con->prepare($sql)){
        $insert->bind_param('sss', $name,$email, $bio);
        $name = $_POST['name'];
        $email = $_POST['email'];
        $bio = $_POST['bio'];
        if($insert->execute()){
            header('location: dashboard.php?id=0');
        }else{
            echo "<script>alert('Some error occured!')</script>";
        }
    }
}
?>