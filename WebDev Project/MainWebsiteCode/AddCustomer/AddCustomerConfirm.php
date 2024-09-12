<!--
Name Of Screen: AddCustomerConfirm
Purpose Of Screen: PHP code that adds the posted customer details to the database

Student Name: Isaiah Andres
Student Number: C00286361
Date:25/02/2024 -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="stylesheet" href="/MainWebsiteCode/MainStyling.css">
        <title>Add A Customer</title>
    </head>

<?php include '/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/MainMenu.php'; ?>
	
        <div class="subjectbox">  
        <?php //Placing the php code in the div for the subjectbox stylises the php results in the same way as the rest of the website

include '../bankConnect.inc.php';  //Uses the php file that starts a new conncetion to the database
date_default_timezone_set("UTC"); //Sets default timezone to utc

echo "The details submitted are: <br>";

echo "First Name :" . $_POST['fname'] . "<br>"; //Displays the information from the html file
echo "Last Name :" . $_POST['lname'] . "<br>"; //Displays the information from the html file
echo "Address :" . $_POST['address'] . "<br>";
echo "Eircode :" . $_POST['eircode'] . "<br>";
$date=date_create($_POST['dob']); //Date object is created
echo "Date of Birth is :" . date_format($date,"d/m/Y") . "<br>"; 
echo "Phone Number :" . $_POST['phoneNo'] . "<br>";
echo "Occupation :" . $_POST['occupation'] . "<br>";
echo "Salary :" . $_POST['salary'] . "<br>";
echo "Email :" . $_POST['email'] . "<br>";
echo "Guarantor :" . $_POST['gname'] . "<br>";

//mysql query that allows the user to insert the values from the html form to the database fields using POST 
$sqlMax =  "SELECT MAX(CustomerId) AS maxID FROM customer";
$result = mysqli_query($con,$sqlMax); //mysql query that selects the highest value from the customer ID from the customer, calling it maxid allows for it to be entered to the row array as an index and to get the result  
$row = mysqli_fetch_assoc($result); //Fetches the result row as an associative array or as a numerical array
$maxID = $row['maxID']; //Assigning the row with maxID as its index to the variable $maxID
$maxID++; //Increments the maxID to represent the next ID which is to be auto-incremented

echo "<br>A record has been added for " . $_POST['fname']; //Displays the information for the corresponding database details
echo "<br>The customer ID is " . $maxID; //Message that shows the newly added customer's ID

$sql = "Insert into customer (CustomerID,FirstName,LastName,Address,Eircode,DOB,Telephone,Occupation,Salary,Email,GuarantorName) VALUES  
($maxID,'$_POST[fname]','$_POST[lname]','$_POST[address]','$_POST[eircode]','$_POST[dob]','$_POST[phoneNo]','$_POST[occupation]','$_POST[salary]','$_POST[email]','$_POST[gname]')"; //Updated input which now allows for the email and phone number from the html file to be entered

if (!mysqli_query($con,$sql)) //Statement that appears if there is an error with the query
{
die ("An Error in the SQL Query: " . mysqli_error($con) );
}

mysqli_close($con);
?>
    
<form action = "screen1.html" method = "POST" > <!--Information taken from screen1.html -->
    <br>
    <input type = "submit" value = "Return to Insert Page"/> <!--Brings user back to the insert page-->
    </body>
</html>

</div>