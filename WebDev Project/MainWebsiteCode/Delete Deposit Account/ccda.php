<!-- Name : Temur Rustamov
 Number : C00280204
 Description : Checking To Close Deposit Account -->

<?php
include '/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/MainMenu.php';	// This includes BankMenu
?>
<link rel="stylesheet" href="./OIR BANK.css">
<!-- php part -->
<div class="subjectbox">
	<h1>Checking Deposit Account Screen</h1>

        <?php 
// assigning data to the declared variables 
			include "bankConnect.inc.php";	

            $customerID = $_POST['showID'];	
			$fname = $_POST['showFirstName'];
			$lname = $_POST['showLastName'];
            $accountID = $_POST['showAccountID'];
            $balance = $_POST['showBalance'];
				
			if ($customerID)	
			{
                if ($balance != 0)	
                {
                    echo "<h4>The balance in that account should be empty first!</h4>";
                }

                else	
                {
                    $sql = "UPDATE account SET DeletedFlag=1 WHERE AccountID='$accountID'";	//sql statement to make the account deleted but not fully

					if(!mysqli_query($con,$sql))    
					{
    					echo "Error ".mysqli_error($con);	
					}

					else
					{
    					if (mysqli_affected_rows($con) != 0)    
    					{
        					echo "<h3>The account with such data will be deleted:</h3>";	
        					echo "<br>Account ID: ". $accountID;
							echo "<br>Customer ID: ". $customerID;
							echo "<br>First Name: ". $fname;
							echo "<br>Last Name: ". $lname;
							echo "<h3><br>Thanks for using our services! </h3>". $lname;
    					}
    					else
    					{
        					echo "Nothing has been implemented! Check everything again!";
    					}
					}
                }
			}

			else	
			{
				echo "<h4>You haven't selected anyone</h4><br>";
			}

		?>
			<form action="cda.php">
				<button type="submit" class="myButton">Do you wish to go back? Click here!</button>
			</form>
		</div>
    </body>
</html>