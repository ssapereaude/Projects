<!-- Name : Temur Rustamov
 Number : C00280204
 Description : Check Deposit Account -->



<?php

session_start();


	//declaration & initialization data to the variables
					

                $_SESSION['showID']=$_POST['showID'];	
				$fname=$_POST['showFirstName'];
				$lname=$_POST['showLastName'];
				$_SESSION['showFirstName']=$fname;
				$_SESSION['showLastName']=$lname;


				$CustomerID = $_SESSION['showID'];
				// if true 
				if ($CustomerID)	
				{
			include "bankConnect.inc.php";	// database connection

					$sql = "SELECT AccountID FROM account WHERE DeletedFlag=0 AND CustomerID='$CustomerID' AND AccountType='deposit'"; 
// getting account id 
					if (!$result=mysqli_query($con, $sql))	
					{
						die( 'Error!'.mysqli_error($con)); // testing part
					}

					if (mysqli_num_rows($result) > 0)	
					{
						//echo "<h4>Such person has already a deposit account!</h4>";
					}

                    else
                    {
                        header('Location: sda.php');	//otherwise redirecting to setting up deposit account page
                    }
				}

				else
				{
						//echo "<h4>No one was selected </h4>";
				}
	
	include '/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/MainMenu.php'; 


			
?>
	<link rel="stylesheet" href="./OIR BANK.css">	

<!-- php part-->
<div class="subjectbox">
			<h1>Check Deposit Account Page</h1>
           
				<form action="oda.php">	
					<h4>Such person already has a deposit account!</h4>
					<button type="submit" class="myButton">Go back</button><!--- return button -->	
				</form>
		</div>
    </body>
</html>