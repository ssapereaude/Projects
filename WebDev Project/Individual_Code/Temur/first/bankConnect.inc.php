<?php
$hostname = "localhost"; 
$username = "mybankaccount"; 
$password = 'B4nk$ecure;24'; 

$dbname = "BankProject"; 

$con = mysqli_connect($hostname, $username, $password, $dbname);

if (!$con)
    {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }
?>