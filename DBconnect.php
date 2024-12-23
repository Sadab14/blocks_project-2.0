<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blocks_inventory";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error){
    die("Connectiono failed: ". $conn->connect_error);
}
else{
    mysqli_select_db($conn,$dbname);
   
}
?>