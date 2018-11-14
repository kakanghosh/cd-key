<?php
$con = mysqli_connect("localhost","developer","developer","cdkey_db");

// Check connection
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}