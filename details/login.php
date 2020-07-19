<?php
include 'setup.php';
mysqli_set_charset($con, 'utf8');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="includes/images/logo.png">
    <link rel="stylesheet" type="text/css" href="includes/styles/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKSBV Majlisul Maarif |tech-admins</title>
</head>
<body>
    <div class="card">
        <?php
        if ($_GET['id']==0){
            ?>
            <h1>log in</h1>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" class="login" name="log" method="get">
                <input type="number" name="id" value="1" hidden>
                <input type="number" placeholder="Registered Mobile Number" name="phone" required><br>
                <input type="reset" value="RESET">
                <input type="submit" name="log" value="LOG IN">
            </form>
            <br><BR>
            <a href="http://majlis.sksbvstate.com">Back to home</a>
            <?php
        }else{
            if (isset($_GET['log'])){
                $mobile = $_GET['phone'];
                $sql= "SELECT * FROM majlis WHERE mobile='$mobile'";
                if ($result = mysqli_query($con, $sql)){
                    if ($result->num_rows != 0){
                        $i = 1;
                        while ($student  = mysqli_fetch_array($result)){
                            ?>
                            <h1>Student - <?php echo $i;?></h1>
                            <h2>Name : <?php echo $student['name'];?></h2><br>
                            <h2>Username : <?php echo $student['username'];?></h2><br>
                            <h2>Password : <?php echo $student['username'].$student['id'];?></h2><br>
                            <?php
                            $i+=1;
                        }
                        echo '<a href="http://majlis.sksbvstate.com/details">CHECK ANOTHER STUDENT</a><br><br>';
                        echo "<br><a href='https://chat.whatsapp.com/K7aF6JhzndJ3DqZ3CblDoN' target='_blank'>നിങ്ങള്‍ വാട്സ്സാപ്പ് ഗ്രൂപ്പില്‍‍ ആഡ് ചെയ്യപ്പെട്ടിട്ടില്ല എങ്കില്‍ ഇവിടെ ക്ലിക്ക് ചെയ്യുക. MESSAGE ADMIN<br></a>";
                    }else{
                        echo "<a>Please enter a registered mobile number! Or contact tech admin +917025033413</a><br><br><br><a href='http://majlis.sksbvstate.com/details'>CHECK ANOTHER STUDENT</a>";
                    }
                }
            }
        }
        ?>
    </div>
</body>
</html>
