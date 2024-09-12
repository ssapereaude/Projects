<!-- Name : Temur Rustamov
 Number : C00280204
 Description : Deposit Transaction Account -->
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
		<h1>Deposit Account Transaction Page</h1>
			<?php
			session_start();
            include "bankConnect.inc.php";
			  //assigning data to the variables
        		$CustomerID=$_SESSION['showID'];	
				$AccountID=$_POST['showID'];
        		$AmountReq=$_POST['amountReq'];
					
        		$TodayDate = date("Y-m-d");
				$firstName=$_SESSION['showFirstName'];
				$lastName=$_SESSION['showLastName'];
				$interestRate=$_SESSION['interest'];
				$Balance=$AmountReq * $interestRate; // expected balance

        		$sql = "INSERT INTO account (AccountID, CustomerID, Balance, AccountType, Date) VALUES ('$AccountID','$CustomerID','$Balance','Deposit','$TodayDate')";    

        		if (!mysqli_query($con, $sql))
        		{
        		    die ("Oops..." . mysqli_error($con) ); 
        		}
			
        		$sql = "INSERT INTO depositaccount (AccountID, RateID, AmountRequested) VALUES ('$AccountID',2,'$AmountReq')";	
			
        		if (!mysqli_query($con, $sql))
        		{
        		    die ("Oops... " . mysqli_error($con) ); 
        		}

				else
				{
					echo "Initials: " .  $firstName . " ," . $lastName;	
					echo "<br>Customer ID: " . $CustomerID;
					echo "<br>Account ID: " . $AccountID;
					echo "<br>Expected Balance: " . $Balance;
					echo "<br>Interest Rate: " . $interestRate * 100 - 100 . " %"; // that is how interest rate was applied
					echo "<br>The today's date is: " . $TodayDate;

				}

				$sql = "SELECT TransactionID FROM transaction WHERE TransactionID=(SELECT MAX(TransactionID) FROM transaction)"; //making sure the transaction will be the last	

				if (!$result=mysqli_query($con, $sql))	
				{
					die( 'Error!'.mysqli_error($con));	
				}

				if (mysqli_num_rows($result) > 0)	
				{
					$row = mysqli_fetch_assoc($result);	
					$transactionID = ($row['TransactionID']+1);	// incrementing transaction id by 1
				}

				else 
				{
					$transactionID=1;
				}
			
        		$sql = "INSERT INTO transaction (TransactionID, AccountID, AccountType, Type, Amount, Date, Balance) VALUES ('$transactionID','$AccountID','Deposit','Deposit','$AmountReq','$TodayDate','$Balance')";	// sql statement to insert values
			
        		if (!mysqli_query($con, $sql))
        		{
        		    die ("Oops... " . mysqli_error($con) ); //testing
        		}

				else
				{
					//transcript
					echo "<br><h4>Your Transcript!</h4>";	
					echo "Account ID: " . $AccountID;
					echo "<br>Account Type: Deposit";
					echo "<br>Transaction Type : Deposit";
					echo "<br>Amount : " . $AmountReq;
					echo "<br>Date : " . $TodayDate;
					echo "<br>Expected Balance : " . $Balance;
				}

				mysqli_close($con);	
				
			?>
				<form action="oda.php">
					<button type="submit" class="myButton">Do you want to return ? Click here!</button>	
				</form>
		</div>
        
		
    </body>
</html>