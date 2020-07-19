<?php
if($_GET['id']==1) {
    if ($_GET['log'] && !empty(trim($_GET['log']))) {
        require_once "../includes/setup/setup.php";
        session_start();
        $username = mysqli_real_escape_string($con, $_GET['username']);
        $pass = mysqli_real_escape_string($con, $_GET['password']);

        $sql = "SELECT * FROM examify_tutors WHERE email=?";
        if ($state = $con->prepare($sql)) {
            $state->bind_param("s", $param);
            $param = trim($username);
            if ($state->execute()) {
                $result = $state->get_result();
                if ($result->num_rows == 1) {
                    $user = $result->fetch_array(MYSQLI_ASSOC);
                    if (password_verify($pass, $user['password'])) {
                        $_SESSION['tutor_id'] = $user['id'];
                        header("location: dashboard.php?id=0");
                    } else {
                        ?>
                        <script defer>alert("USERNAME AND PASSWORD DOESN'T MATCH");</script>
                        <?php

                    }
                } else {
                    ?>
                    <script defer>alert("USER NOT FOUND");</script>
                    <?php
                }
            }
        }
        $state->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../includes/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../includes/styles/admin/admin_login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examify | System Admin</title>
</head>
<body>
<div class="card">
    <h1>tutor log in</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" class="login" name="log" method="get">
        <input type="number" name="id" value="1" hidden>
        <input type="email" placeholder="EMAIL" name="username" required><br>
        <input type="password" placeholder="PASSWORD" name="password" required><br><br>
        <input type="reset" value="RESET">
        <input type="submit" name="log" value="LOG IN">
        <br><br><br>
        <h3><a href="../index.html">GO HOME</a></h3>
    </form>
</div>
</body>
</html>