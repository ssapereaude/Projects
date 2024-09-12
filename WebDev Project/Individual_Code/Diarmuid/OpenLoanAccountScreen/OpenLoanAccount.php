<?php 

// Name : Diarmuid O'Neill
// Number : C00282898
// Description : Screen allowing a user to choose a customer to create a loan account for
// Date : Feb 2024

	include "BankMenu.php";	// Includes the Bank Menu
	include "bankConnect.inc.php";	// database connection
?>
		
		<script src="OpenLoanAccount.js"></script>	<!-- Links to javascript file -->

		<div class="subjectbox">
			<h1>Open Loan Account</h1>
			<h4>Please select a customer for whom you want to create a loan account</h4>
			<h4>Choose a customer from the drop-down or search up their customerID </h4>
			<p class="subjectboxtext">

				<form action="OpenLoanAccount.php" method="POST"> <!-- This Form relates to the searchbar, upon searching the page is refreshed and the main form is populated -->

                	<?php
						// This block of PHP relates to the drop-down listbox

						$sql = "SELECT CustomerID, FirstName, LastName, Address, DOB, Telephone FROM customer WHERE DeletedFlag=0";		// Prepared SQL Statement

						if (!$result=mysqli_query($con, $sql))		// Query is executed here
						{
							die( 'Error in querying the database'.mysqli_error($con));	// Error Checking
						}

						echo "<select name='listbox' id='listbox' onclick='populate()'>";	// Listbox, upon clicking the main form is populated with the data of the selected customer

						while ($row=mysqli_fetch_array($result)) // Loops through the array while there are results in the array
						{
							$CustomerID = $row['CustomerID'];	// This block takes data from the rows in the database and assigns them to variables
							$FirstName = $row['FirstName'];
							$LastName = $row['LastName'];
							$Address  = $row['Address'];
							$dateOfBirth = $row['DOB'];
							$DOB = date_create($row['DOB']);
							$DOB = date_format($DOB, "Y-m-d");
							$Telephone = $row['Telephone'];

							$allText = "$CustomerID, $FirstName, $LastName, $Address, $DOB, $Telephone";
							echo "<option value = '$allText'>$FirstName $LastName</option>";	// This populates the listbox with options
						}
						echo "</select>";
					?>

				
					<input style="width: 100px; margin-left:20px;" type="text" name="search" placeholder="CustomerID..." > <!-- SearchBox -->
					<button type="submit">Search</button> <!-- Search Button, populates main form upon clicking -->

				</form>

				<?php

					$customerID=null; // CustomerID initialized to null
					
					if(isset($_POST['search'])) // Checks if search is set
					{
						$customerID=$_POST['search']; // If it is set, sets customerID to the search term
						
						$sql = "SELECT CustomerID, FirstName, LastName, Address, DOB, Telephone FROM customer WHERE DeletedFlag=0 AND CustomerID='$customerID'";	// Prepared SQL Statement

						if (!$result=mysqli_query($con, $sql))	// Executes statement
						{
							die( 'Error in querying the database'.mysqli_error($con));	// Error checking
						}

    					if (mysqli_num_rows($result) > 0) // If results are found
						{
    					    $row = mysqli_fetch_assoc($result);

    					    // Fetching values from the database

    					    $CustomerID = $row['CustomerID'];
    					    $FirstName = $row['FirstName'];
    					    $LastName = $row['LastName'];
    					    $Address  = $row['Address'];
    					    $DOB = date('Y-m-d', strtotime($row['DOB']));
    					    $Telephone = $row['Telephone'];
    					}

						else 
						{
							// Handle case when no results are found
							$CustomerID = $FirstName = $LastName = $Address = $DOB = $Telephone = "";
						}
					}

					mysqli_close($con);	// Closes database connection
					
				?>
			</p>

			<p id="display">
				<form id="myForm" action="CheckLoanAccount.php" onload="lock()" onsubmit="toggleLock()" method="POST">	<!-- locks form onload, unlocks to allow posting upon submission, moves to CheckLoanAccount.php upon submission -->

					<div class="inputbox">
						<label>Customer ID : </label>
						<input style="pointer-events:none" type="text" tabindex="-1" name="showID" id="showID" disabled value="<?php echo $CustomerID; ?>">
					</div>	
					
					<div class="inputbox">
						<label>First Name : </label>
						<input type="text" name="showFirstName" id="showFirstName" disabled value="<?php echo $FirstName; ?>">
					</div>
					
					<div class="inputbox">
						<label>LastName : </label>
						<input type="text" name="showLastName" id="showLastName" disabled value="<?php echo $LastName; ?>">
					</div>
					
					<div class="inputbox">
						<label>Address : </label>
						<input type="text" name="showAddress" id="showAddress" disabled value="<?php echo $Address; ?>">
					</div>
					
					<div class="inputbox">
						<label>Date of Birth : </label>
						<input type="date" name="showDOB" id="showDOB" disabled value="<?php echo $DOB; ?>">
					</div>
					
					<div class="inputbox">
						<label>Telephone : </label>
						<input type="text" name="showTelephone" id="showTelephone" disabled value="<?php echo $Telephone; ?>">
					</div>

					<input class="myButton" type="submit" value="Confirm Details">

				</form>
			</p>
		</div>
    </body>
</html>