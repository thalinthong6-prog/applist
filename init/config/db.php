<?php
$conn = mysqli_connect("localhost","root","","tbl_users");

if(!$conn){
    echo "Database connection failed";
}
?>