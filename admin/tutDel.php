<?php
include "../includes/setup/setup.php";
include "../includes/setup/session.php";

if($_GET['id']){
    $sql = "DELETE FROM examify_tutors WHERE id=?";
    if($oper = $con->prepare($sql)){
        $oper->bind_param('i',$id);
        $id = $_GET['id'];
        if($oper->execute()){
            header('location: tutors.php?id=0');
        }else{
            echo "<script>alert('Some error Occured')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../includes/images/logo.png" type="image/x-icon">
    <title>Examify | Tutor </title>
    <link rel="stylesheet" href="../includes/styles/admin/tutor_reg.css">
</head>
<body>
<?php include "navigation.html";?>

</body>
</html>
