<?php
 $con = mysqli_connect("localhost","root","","curies");
// Check connectionMariaDB - majlis_updated@localhost
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
mysqli_set_charset($con, 'utf8');
?>