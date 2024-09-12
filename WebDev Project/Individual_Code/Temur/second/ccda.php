<!-- Name : Temur Rustamov
 Number : C00280204
 Description : Checking To Close Deposit Account -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="initial-scale=1.0" />
    <link rel="stylesheet" href="OIR BANK.css" />
    <title>OIR Banking System</title>
  </head>
  <body>
    <div class="navbar">
      <ul class="nav-list" style="list-style-type: none">
        <li><a href="#">Lodgements</a></li>
        <li><a href="#">Withdrawals</a></li>
        <li class="dropdown">
          <a href="#">Customers</a>
          <div class="dropdown-content">
            <a class="dropdownItem" href="#">Create</a><br />
            <a class="dropdownItem" href="#">View/Amend</a><br />
            <a class="dropdownItem" href="#">Delete</a>
          </div>
        </li>
        <li class="dropdown">
          <a href="#">Accounts</a>
          <div class="dropdown-content">
            <div class="nestedLoan">
              <a class="dropdownItem" href="#">Loan Account</a>
              <div class="dropdown-content-loan">
                <a class="dropdownItem" href="#">Create</a><br />
                <a class="dropdownItem" href="#">View/Amend</a><br />
                <a class="dropdownItem" href="#">Delete</a>
              </div>
            </div>
            <br />
            <div class="nestedCurrent">
              <a class="dropdownItem" href="#">Current Account</a>
              <div class="dropdown-content-current">
                <a class="dropdownItem" href="#">Create</a><br />
                <a class="dropdownItem" href="#">View/Amend</a><br />
                <a class="dropdownItem" href="#">Delete</a>
              </div>
            </div>
            <br />
            <div class="nestedDeposit">
              <a class="dropdownItem" href="#">Deposit Account</a>
              <div class="dropdown-content-deposit">
                <a class="dropdownItem" href="#">Create</a><br />
                <a class="dropdownItem" href="#">View/Amend</a><br />
                <a class="dropdownItem" href="#">Delete</a>
              </div>
            </div>
          </div>
        </li>
        <li>
          <a href="OIR BANK.html"><img src="logo2.png" alt="Brand logo" /></a>
        </li>
        <li class="dropdown">
          <a href="#">Management Menu</a>
          <div class="dropdown-content">
            <div class="nestedCurrent">
              <a class="dropdownItem" href="#">Charge/Calculate Interest</a
              ><br />
              <div class="dropdown-content-current">
                <a class="dropdownItem" href="#">Overdrawn Current Accounts</a
                ><br />
                <a class="dropdownItem" href="#">View/Amend</a><br />
                <a class="dropdownItem" href="#">Delete</a>
              </div>
            </div>
            <a class="dropdownItem" href="#">Change Rates</a><br />
          </div>
        </li>
        <li><a href="#">Quotes</a></li>
        <li><a href="#">Reports</a></li>
        <li><a href="#">Change Password</a></li>
      </ul>
    </div>
<!-- php part -->
<div class="subjectbox">
	<h1>Checking Deposit Account Screen</h1>

        <?php 
// assigning data to the declared variables 
			include "bankConnect.inc.php";	
            session_start();

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
        					echo "<br>Your Account ID ". $accountID;
							echo "<br>Your Customer ID ". $customerID;
							echo "<br>Your First Name ". $fname;
							echo "<br>Your Last Name ". $lname;
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