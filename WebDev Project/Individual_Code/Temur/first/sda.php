<!-- Name : Temur Rustamov
 Number : C00280204
 Description : Setting Deposit Account -->

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

		<div class="subjectbox">
			<h1>Setup Deposit Account Page</h1>

            <?php 
			
			session_start();	
			include "bankConnect.inc.php";
				// assigning data to the declared variables
				$CustomerID = $_SESSION['showID'];	
				$firstName = $_SESSION['showFirstName'];
				$lastName = $_SESSION['showLastName'];
				

				

				echo "<h4>Congratulations, account ID has been sucessfully created!</h4>"; 

				$sql = "SELECT AccountID FROM account WHERE AccountID=(SELECT MAX(AccountID) FROM account)";	//maing sure that the id will be the last one 

				if (!$result=mysqli_query($con, $sql))	
				{
					die( 'Error!'.mysqli_error($con));	
				}

				if (mysqli_num_rows($result) > 0)	
				{
					$row = mysqli_fetch_assoc($result);	
					$AccountID = ($row['AccountID']+1);	//incrementing id by 1
				}

				else 
				{
					$AccountID=1;
				}

				$sql = "SELECT InterestRate FROM rate WHERE RateID=2";	//getting rate which is used for applying to deposit accounts

				if (!$result=mysqli_query($con, $sql))	
				{
					die( 'Error!'.mysqli_error($con));	
				}

				if (mysqli_num_rows($result) > 0) 
				{
					$row = mysqli_fetch_assoc($result);

					$InterestRate = $row['InterestRate'];

					$_SESSION['interest']=$InterestRate;	
				}

				mysqli_close($con);	

			?>
<!-- html part display form -->
			<script> var InterestRate = <?php echo $InterestRate;?>; </script>	

			<p id="display">
				<form id="myForm" onsubmit="return confirmCheck()" onload="lock()" action="dat.php" method="POST">	
					<div class="inputbox">
						<label>Your Account ID </label>
						<input type="text" name="showID" id="showID" disabled value="<?php echo $AccountID; ?>">
					</div>
					<div class="inputbox">
						<label>The Amount Requested is </label>
						<input type="number" min="0" step="100" name="amountReq" id="amountReq" placeholder="Amount" required>
					</div>

          			<input class="myButton" type="submit" value="Confirm">
				</form>

				<form action="oda.php">
					<button type="submit" class="myButton">Would you like to return ? Click here!</button>
				</form>
			</p>
		</div>
	
	<script src="oda.js"></script>	
    </body>
</html>








