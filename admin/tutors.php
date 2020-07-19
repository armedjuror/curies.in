<?php
include "../includes/setup/setup.php";
include "../includes/setup/session.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../includes/images/logo.png" type="image/x-icon">
    <title>Examify | Tutor Registration</title>
    <link rel="stylesheet" href="../includes/styles/admin/tutor_reg.css">
</head>
<body>
    <?php include "navigation.html";?>
    <div class="wrapper">
        <div class="card">
            <h1>Tutors</h1>
            <ol>
                <?php
                    $sql = mysqli_query($con, "SELECT * FROM examify_tutors");
                    if($sql->num_rows){
                        while( $tutor = mysqli_fetch_array($sql)){
                            ?>
                            <li><ul><li><?php echo $tutor['name']; ?></li><li><a href="<?php echo 'tutor.php?id='.$tutor['id']; ?>">VIEW</a></li><li><a href="<?php echo 'tutDel.php?id='.$tutor['id']; ?>">DELETE</a></li></ul></li>
                            <?php
                        }
                    }
                ?>
            </ol>
        </div>
        <div class="card">
            <h1>Tutor Registration</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']."?id=1";?>" method="post">
                <input type="text" name="name" id="name" placeholder="NAME *" required>
                <input type="email" name="email" id="email" placeholder="EMAIL *" required>
                <input type="password" name="password" id="password" placeholder="PASSWORD *" required>
                <input type="checkbox" name="toggleShow" id="toggle" onclick="togglePassword()">
                <label for="toggle">SHOW PASSWORD</label>
                <textarea name="bio" id="bio" placeholder="Tell Something About You"></textarea>
                <input type="submit" value="REGISTER" name="register">
            </form>
        </div>
    </div>
    <script>
        function togglePassword() {
            const elem = document.getElementById('password');
            if(elem.type === 'password')elem.type='text';
            else elem.type='password';
        }
    </script>
</body>
</html>
<?php
    if($_GET['id']){
        $sql = "INSERT INTO examify_tutors (`name`, email, `password`, bio) VALUES (?,?,?,?)";
        if($insert = $con->prepare($sql)){
            $insert->bind_param('ssss', $name,$email, $password, $bio);
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash(trim($_POST['password']),PASSWORD_DEFAULT);
            $bio = $_POST['bio'];
            if($insert->execute()){
                header('location: tutors.php?id=0');
            }else{
                echo "<script>alert('Some error occured!')</script>";
            }
        }
    }
?>

