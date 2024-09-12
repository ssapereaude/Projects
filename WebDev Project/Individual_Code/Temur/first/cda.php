<!-- Name : Temur Rustamov
 Number : C00280204
 Description : Check Deposit Account -->

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
<!-- php part-->
<div class="subjectbox">
			<h1>Check Deposit Account Page</h1>

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

					include "bankConnect.inc.php";	

					$sql = "SELECT AccountID FROM account WHERE DeletedFlag=0 AND CustomerID='$CustomerID' AND AccountType='deposit'"; 
// getting account id 
					if (!$result=mysqli_query($con, $sql))	
					{
						die( 'Error!'.mysqli_error($con)); // testing part
					}

					if (mysqli_num_rows($result) > 0)	
					{
						echo "<h3>Such person already has a deposit account<br>Let's try again!</h3>"; // means there is already a deposit account created for that user
					}

                    else
                    {
                        header('Location: sda.php');	//otherwise redirecting to setting up deposit account page
                    }
				}

				else
				{
					echo "<h4>Unfortunately, you didn't select anyone. If you wish to continue, go back and select again.</h4>"; //means no customer id was selected 	
				}

			?>
				<form action="oda.php">		
					<button type="submit" class="myButton">Would you like to go back to the previous page ? Click here!</button><!--- return button -->	
				</form>
		</div>
    </body>
</html>