<!-- Name : Temur Rustamov
 Number : C00280204
 Description : Setting Deposit Account -->
<?php 
session_start();
	include '/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/MainMenu.php';	// includes the BankMenu
?>
<script src="oda.js"></script>	<!-- Links to javascript file -->
<link rel="stylesheet" href="./OIR BANK.css">
<!-- php part -->

		<div class="subjectbox">
			<h1>Setup Deposit Account Page</h1>

            <?php 
			
include "bankConnect.inc.php";	//to connect to our db

			
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
						<input type="text" name="showID" id="showID" tabindex="-1" disabled value="<?php echo $AccountID; ?>">
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








