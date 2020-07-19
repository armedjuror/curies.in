<?php
$con = mysqli_connect('localhost', 'root', '', 'curies');
if (!$con){
    echo $con->error;
}
mysqli_set_charset($con, 'utf-8');