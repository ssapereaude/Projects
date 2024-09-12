<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="initial-scale=1.0" />
    <link rel="stylesheet" href="OIR BANK1.css" />
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
			<h1>Transaction History</h1>
            <h4>Previous Transactions</h4>
			<div id="history">
			
		<?php

		    include	"bankConnect.inc.php";
			date_default_timezone_set("GMT");
				echo $_POST["search"];
			if (isset($_POST["search"]) && $_POST["search"] != null)
				{
					$search = $_POST["search"];
                    if ($_POST["selection"] == "CustomerID")
                        {

                            $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE account.DeletedFlag=0 AND account.AccountType='deposit' AND customer.CustomerID = $search";
                        }
                    else
                        {
                            $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE account.DeletedFlag=0 AND account.AccountType='deposit' AND customer.CustomerID = $search";
                        }
					if(!$result = mysqli_query($con, $sql))
                        {
                            die('Oops...' . mysqli_error($con));
                        }
					if ($row = mysqli_fetch_array($result))
						{
							echo "
							<script>
								document.getElementById('showID').innerHTML = '';
							</script>";
							$customerid = $row['CustomerID'];
                        	$firstname = $row['FirstName'];
                        	$surname = $row['LastName'];
                        	$address = $row['Address'];
                        	$eircode = $row['Eircode'];
                        	$dateOfBirth = $row['DOB'];
                        	$dob = date_create($dateOfBirth);
                        	$dob = date_format($dob,"Y-m-d");
                        	$telephone = $row['Telephone'];
                            $accountid = $row['AccountID'];
                            $balance = $row['Balance'];
							$Amount = $row['AmountRequested'];
                        	$alltext = "'$customerid,$firstname,$surname,$address,$eircode,$dob,$telephone,$accountid,$balance,$Amount'";
							echo"
							<script>
								var result = $alltext;
								var customerDetails = result.split(',');
                				document.getElementById('showCID').value = personDetails[0];
								document.getElementById('showID').value = personDetails[1];
								document.getElementById('showFirstName').value = personDetails[2];
								document.getElementById('showLastName').value = personDetails[3];
								document.getElementById('showAddress').value = personDetails[4];
								document.getElementById('showEircode').value = personDetails[5];
								document.getElementById('showDOB').value = personDetails[6];
								document.getElementById('showTelephone').value = personDetails[7];
								document.getElementById('showBalance').value = personDetails[8];
								document.getElementById('showAmount').value = personDetails[9];
							</script>";
							include("fetchTransactions.php");
						}
					else
						{
							echo
							"
							<script>
							document.getElementById('showID').innerHTML = 'The $_POST[selection] $search was not found.';
							</script>
							";
						};
				}
		?>
		</div>
		</div>
	  </body>
</html>