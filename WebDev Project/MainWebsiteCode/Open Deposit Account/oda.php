<!-- Name : Temur Rustamov
 Number : C00280204
 Description : Opening Deposit Account -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="stylesheet" href="OIR BANK.css">
        <title>OIR Banking System</title>
    </head>
    <body>
		<!--The start of the menu bar at the top-->
		<div class="navbar">
			<!--The list of items that make up the options on the top menu bar-->
			<ul class="nav-list" style="list-style-type: none">
				<li><a href="/MainWebsiteCode/Lodgements/CustomerLodgement.php">Lodgements</a></li>
				<li><a href="/MainWebsiteCode/Withdrawals/withdrawCash.html.php">Withdrawals</a></li>
				<!--Dropdown menu for customers-->
				<li class="dropdown">
					<a href="#">Customers</a>
					<div class="dropdown-content">
						<a class="dropdownItem" href="/MainWebsiteCode/AddCustomer/AddCustomer.php">Create</a><br> 
						<a class="dropdownItem" href="/MainWebsiteCode/AmendViewCustomer/AmendViewCustomer.php">View/Amend</a><br>
						<a class="dropdownItem" href="/MainWebsiteCode/DeleteCustomer/CustomerDeletion.php">Delete</a>
					</div>
				</li>
				<!--Dropdown menu for all accounts, with nested dropdown menus-->
				<li class="dropdown">
					<a href="#">Accounts</a>
					<div class="dropdown-content">
						<!--The dropdown menu for loan accounts, nested within the accounts dropdown menu-->
						<div class="nestedLoan">
							<a class="dropdownItem" href="#">Loan Account</a>
							<div class="dropdown-content-loan">
								<a class="dropdownItem" href="/MainWebsiteCode/OpenLoanAccountScreen/OpenLoanAccount.php">Create</a><br>
								<a class="dropdownItem" href="/MainWebsiteCode/AmendViewLoanAccountScreen/AmendViewLoanAccount.php">View/Amend</a><br>
								<a class="dropdownItem" href="/MainWebsiteCode/CloseLoanAccountScreen/CloseLoanAccount.php">Delete</a>
							</div>
						</div><br>
						<!--The dropdown menu for current accounts, nested within the accounts dropdown menu-->
						<div class="nestedCurrent">
							<a class="dropdownItem" href="#">Current Account</a>
							<div class="dropdown-content-current">
								<a class="dropdownItem" href="/MainWebsiteCode/AddCurrentAccount/addCurrentAccount.html.php">Create</a><br>
								<a class="dropdownItem" href="/MainWebsiteCode/AmendViewCurrentAccount/amendViewCurrentAccount.html.php">View/Amend</a><br>
								<a class="dropdownItem" href="/MainWebsiteCode/DeleteCurrentAccount/deleteCurrentAccount.html.php">Delete</a>
							</div>
						</div><br>
						<!--The dropdown menu for deposit accounts, nested within the accounts dropdown menu-->
						<div class="nestedDeposit">
							<a class="dropdownItem" href="#">Deposit Account</a>
							<div class="dropdown-content-deposit">
								<a class="dropdownItem" href="/MainWebsiteCode/Open Deposit Account/oda.php">Create</a><br>
								<a class="dropdownItem" href="/MainWebsiteCode/View Deposit Account/vda.php">View/Amend</a><br>
								<a class="dropdownItem" href="/MainWebsiteCode/Delete Deposit Account/dda.php">Delete</a>
							</div>
						</div>
					</div>
				</li>
				<!--Logo of the bank, which links back to the homepage-->
				<li><a href="/MainWebsiteCode/OIR BANK.html.php"><img src="/MainWebsiteCode/logo2.png" alt="Brand logo"></a></li>
				<li class="dropdown">
					<a href="#">Management Menu</a>
					<div class="dropdown-content">
						<!--NOTE: nestedCurrent and dropdown-content-current are used here for the sake of reducing code redundancy. The name isnt fitting, but it works perfectly-->
						<div class="nestedCurrent">
							<a class="dropdownItem" href="#">Charge/Calculate Interest</a><br>
							<div class="dropdown-content-current">
								<a class="dropdownItem" href="/MainWebsiteCode/Placeholder/placeholder.html.php">Overdrawn Current Accounts</a><br>
								<a class="dropdownItem" href="/MainWebsiteCode/Placeholder/placeholder.html.php">Deposit Accounts</a><br>
								<a class="dropdownItem" href="/MainWebsiteCode/Placeholder/placeholder.html.php">Current Accounts</a>
							</div>
						</div>
						<!--NOTE: nestedDeposit and dropdown-content-deposit areused here for the sake of reducing code redundancy. The name isnt fitting, but it works perfectly-->
						<div class="nestedDeposit">
							<a class="dropdownItem" href="#">Change Rates</a><br>
							<div class="dropdown-content-deposit">
								<a class="dropdownItem" href="/MainWebsiteCode/Placeholder/placeholder.html.php">Deposit Accounts</a><br>
								<a class="dropdownItem" href="/MainWebsiteCode/Placeholder/placeholder.html.php">Current Accounts</a><br>
								<a class="dropdownItem" href="/MainWebsiteCode/Placeholder/placeholder.html.php">Loan Accounts</a>
							</div>
						</div>
				</li>
				<li><a href="#">Quotes</a></li>
				<li class="dropdown">
					<a href="#">Reports</a>
					<div class="dropdown-content">
							<a class="dropdownItem" href="/MainWebsiteCode/Deposit Account History/dh.php">Deposit History</a><br>
							<a class="dropdownItem" href="/MainWebsiteCode/AccountReportScreen/AccountReportScreen.php">Account Reports</a><br>
					</div>
				</li>
				<li><a href="/MainWebsiteCode/Placeholder/placeholder.html.php">Change Password</a></li>
			</ul>
		</div>




		<!-- php part -->

		
		<script src="oda.js"></script>

		<div class="subjectbox">
			<h1>Open Deposit Account Page</h1>
			<p class="subjectboxtext">

				<form action="oda.php" method="POST"> 

                	<?php
					 include "bankConnect.inc.php";	//to connect to our db
                    
				

						$sql = "SELECT CustomerID, FirstName, LastName, Address, DOB, Telephone FROM customer WHERE DeletedFlag=0"; //sql statement		

						if (!$result=mysqli_query($con, $sql))		
						{
							die( 'Error!'.mysqli_error($con));	// validation
						}

						echo "<select name='listbox' id='listbox' onclick='populate()'>";	//to populate data

						while ($row=mysqli_fetch_array($result)) //initialization the data that we got from our db into variables
						{
							$CustomerID = $row['CustomerID'];	
							$FirstName = $row['FirstName'];
							$LastName = $row['LastName'];
							$Address  = $row['Address'];
							$dateOfBirth = $row['DOB'];
							$DOB = date_create($row['DOB']);
							$DOB = date_format($DOB, "Y-m-d");
							$Telephone = $row['Telephone'];

							$allText = "$CustomerID, $FirstName, $LastName, $Address, $DOB, $Telephone";
							echo "<option value = '$allText'>$FirstName $LastName</option>";	
						}
						echo "</select>";
					?>

				
					<input style="width: 200px; margin-left:50px;" type="text" name="search" placeholder="CustomerID" > 
					<button type="submit">Click on me to search!</button> <!-- search button -->

				</form>

				<?php

					$customerID=null; //initializing to empty value first of all 
					
					if(isset($_POST['search'])) // if it was set 
					{
						$customerID=$_POST['search']; // setting to the value that was assigned by user
						
						$sql = "SELECT CustomerID, FirstName, LastName, Address, DOB, Telephone FROM customer WHERE DeletedFlag=0 AND CustomerID='$customerID'";	//sql statement 

						if (!$result=mysqli_query($con, $sql))	
						{
							die( 'Error!'.mysqli_error($con));	//validation
						}

    					if (mysqli_num_rows($result) > 0) 
						{
    					    $row = mysqli_fetch_assoc($result);
							//assinging data from sql to the variables

    					    $CustomerID = $row['CustomerID'];
    					    $FirstName = $row['FirstName'];
    					    $LastName = $row['LastName'];
    					    $Address  = $row['Address'];
    					    $DOB = date('Y-m-d', strtotime($row['DOB']));
    					    $Telephone = $row['Telephone'];
    					}

						else 
						{
							$CustomerID = $FirstName = $LastName = $Address = $DOB = $Telephone = ""; // empty values
						}
					}

					mysqli_close($con);	
					
				?>
			</p>
	  <!-- form in html-->

			<p id="display">
				<form id="myForm" action="cda.php" onload="lock()" onsubmit="toggleLock()" method="POST">	

					<div class="inputbox">
						<label>Your Customer ID</label>
						<input style="pointer-events:none" type="text" tabindex="-1" name="showID" id="showID" disabled value="<?php echo $CustomerID; ?>">
					</div><br>
					
					<div class="inputbox">
						<label>Your First Name</label>
						<input type="text" name="showFirstName" id="showFirstName" disabled value="<?php echo $FirstName; ?>">
					</div><br>
					
					<div class="inputbox">
						<label>Your Last Name</label>
						<input type="text" name="showLastName" id="showLastName" disabled value="<?php echo $LastName; ?>">
					</div><br>
					
					<div class="inputbox">
						<label>Your Address</label>
						<input type="text" name="showAddress" id="showAddress" disabled value="<?php echo $Address; ?>">
					</div><br>
					
					<div class="inputbox">
						<label>Your Date of Birth</label>
						<input type="date" name="showDOB" id="showDOB" disabled value="<?php echo $DOB; ?>">
					</div><br>
					
					<div class="inputbox">
						<label>Your Telephone Number</label>
						<input type="text" name="showTelephone" id="showTelephone" disabled value="<?php echo $Telephone; ?>">
					</div><br>

					<input class="myButton" type="submit" value="Confirm">

				</form>
			</p>
		</div>
    </body>
</html>