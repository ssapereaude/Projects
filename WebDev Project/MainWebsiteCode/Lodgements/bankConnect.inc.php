<!--
Name Of Screen: CustomerListbox.php
Purpose Of Screen: Drop down list that is populated with results from a MySQL query to select details from the customer table 
    
Student Name: Isaiah Andres
Student Number: C00286361
Date:31/03/2024 -->

<?php
$hostname = "localhost"; // name of host or ip address
$username = "mybankaccount"; //MySQL username
$password = 'B4nk$ecure;24'; //mySQL Password

$dbname = "BankProject"; //Database Name

$con = mysqli_connect($hostname, $username, $password, $dbname); //Opens a new connection to the mysql server

if (!$con)
    {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }
?>
</body>
</html>