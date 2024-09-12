<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="stylesheet" href="OIR BANK.css">
        <title>OIR Banking System</title>
    </head>
    <body>
		<?PHP include("menu.html.php");?>
		<!--The main WELCOME message for the system, styled with the subjectbox class. Any mention of subjectboxes refers to the boxes found within the main body of the page underneath the menu bar-->
		<div class="subjectbox">
			<h1>Delete a Current Account</h1>
			<p class="subjectboxtext">
			Please select a customer from the dropdown, or enter their customer or account number in the provided box.
			<div id="found"></div>
            <?php
                include "bankConnect.inc.php";
				date_default_timezone_set("GMT");
				
                $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance FROM (customer INNER JOIN account ON customer.CustomerID = account.CustomerID) WHERE account.DeletedFlag=0 AND account.AccountType='current'";

                if(!$result = mysqli_query($con, $sql))
                    {
                        die('ERROR IN QUERYING THE DATABASE' . mysqli_error($con));
                    }
                echo"<br><select name='listbox' id='listbox' onclick='populate()'>";
                while($row = mysqli_fetch_array($result))
                    {
                        $customerid = $row['CustomerID'];
                        $firstname = $row['FirstName'];
                        $surname = $row['LastName'];
                        $address = $row['Address'];
                        $eircode = $row['Eircode'];
                        $dateOfBirth = $row['DOB'];
                        $dob = date_create($dateOfBirth);
                        $dob = date_format($dob,"d/m/Y");
                        $telephone = $row['Telephone'];
                        $accountid = $row['AccountID'];
                        $balance = $row['Balance'];
                        $alltext = "$customerid,$firstname,$surname,$address,$eircode,$dob,$telephone,$accountid,$balance";
                        echo"<option value = '$alltext'>$firstname $surname</option>";
                    }
                echo "</select>";
                mysqli_close($con);
            ?>
            </p>
			<form action="deleteCurrentAccount.html.php" method="post">
				<label for="search">Search By ID</label>
				<input type="number" name="search" id="search">
                <input type="radio" id="customerID" name="selection" value="CustomerID" checked>
                Customer ID
                <input type="radio" id="accountID" name="selection" value="AccountID">
                Account ID
				<button type="submit">Search Customers</button>
			</form>
            <form class="customerDetails" action="currentAccountDeleted.html.php" method="post" onsubmit="return confirmDetails()">
                <label for="displayid">Customer ID</label>
                <input type="number" name="displayid" id="displayid" disabled placeholder="Customer ID">
                <label for="displayfname">First Name</label>
                <input type="text" name="displayfname" id="displayfname" disabled placeholder="First Name">
                <label for="displaysname">Surname</label>
                <input type="text" name="displaysname" id="displaysname" disabled placeholder="Surname">
                <label for="displayaddress">Address</label>
                <input type="text" name="displayaddress" id="displayaddress" disabled placeholder="Address">
                <label for="displayeircode">Eircode</label>
                <input type="text" name="displayeircode" id="displayeircode" disabled placeholder="Eircode">
                <label for="displaydob">Date of Birth</label>
                <input type="date" name="displaydob" id="displaydob" disabled placeholder="Date of Birth">
                <label for="displaytelephone">Telephone</label>
                <input type="text" name="displaytelephone" id="displaytelephone" disabled placeholder="Telephone">
                <label for="displayaid">Account ID</label>
                <input type="number" name="displayaid" id="displayaid" disabled placeholder="Account ID">
                <label for="displaybalance">Balance</label>
                <input type="number" name="displaybalance" id="displaybalance" disabled placeholder="Balance">
				<button style="margin-left:35%; margin-top: 20px; width: 200px;" type="submit">Delete Account</button>
            </form>
		</div>
		<?php
		    include	"bankConnect.inc.php";
			date_default_timezone_set("GMT");
			if (isset($_POST["search"]) && $_POST["search"] != null)
				{
					$search = $_POST["search"];
                    if ($_POST["selection"] == "CustomerID")
                        {
                            $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance FROM (customer INNER JOIN account ON customer.CustomerID = account.CustomerID) WHERE account.DeletedFlag=0 AND account.AccountType='current' AND customer.CustomerID = $search";
                        }
                    else
                        {
                            $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance FROM (customer INNER JOIN account ON customer.CustomerID = account.CustomerID) WHERE account.DeletedFlag=0 AND account.AccountType='current' AND account.AccountID = $search";
                        }
					if(!$result = mysqli_query($con, $sql))
                        {
                            die('ERROR IN QUERYING THE DATABASE' . mysqli_error($con));
                        }
					if ($row = mysqli_fetch_array($result))
						{
							echo "
							<script>
								document.getElementById('found').innerHTML = '';
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
                        	$alltext = "'$customerid,$firstname,$surname,$address,$eircode,$dob,$telephone,$accountid,$balance'";
							echo"
							<script>
								var result = $alltext;
								var customerDetails = result.split(',');
                				document.getElementById('displayid').value = customerDetails[0];
                				document.getElementById('displayfname').value = customerDetails[1];
                				document.getElementById('displaysname').value = customerDetails[2];
                				document.getElementById('displayaddress').value = customerDetails[3];
                				document.getElementById('displayeircode').value = customerDetails[4];
                				document.getElementById('displaydob').value = customerDetails[5];
                				document.getElementById('displaytelephone').value = customerDetails[6];
                                document.getElementById('displayaid').value = customerDetails[7];
                                document.getElementById('displaybalance').value = customerDetails[8];
							</script>";
						}
					else
						{
							echo
							"
							<script>
							document.getElementById('found').innerHTML = 'The $_POST[selection] $search was not found.';
							</script>
							";
						}
				}
			mysqli_close($con);
		?>
        <script>
			if (document.getElementById('displayid').disabled == false)
				{
					toggleLock();
				}
            function populate()
            {
                var sel = document.getElementById("listbox");
                var result;
                result = sel.options[sel.selectedIndex].value;
                var customerDetails = result.split(',');
                document.getElementById("displayid").value = customerDetails[0];
                document.getElementById("displayfname").value = customerDetails[1];
                document.getElementById("displaysname").value = customerDetails[2];
                document.getElementById("displayaddress").value = customerDetails[3];
                document.getElementById("displayeircode").value = customerDetails[4];
				var date = customerDetails[5].split('/');
				var dateString = date[2] + "-" + date[1] + "-" + date[0];
				document.getElementById("displaydob").value = dateString;
                document.getElementById("displaytelephone").value = customerDetails[6];
                document.getElementById('displayaid').value = customerDetails[7];
                document.getElementById('displaybalance').value = customerDetails[8];
            }
			function confirmDetails()
			{
				if (document.getElementById("displayid").value > 0)
				{
					var status = confirm("Are you sure you wish to delete the Current Account of the following Customer? \n ID: " + document.getElementById("displayid").value + " Name: " + document.getElementById("displayfname").value + " " + document.getElementById("displaysname").value);
					if (status)
						{
							toggleLock();
						}
					return status;
				}
				else
				{
					alert("No Customer Selected!");
					return false;
				}
			}
			function toggleLock()
			{
				if (document.getElementById('displayid').disabled)
				{
					document.getElementById('displayaid').disabled = false;
                	document.getElementById('displaybalance').disabled = false;
				}
				else
				{
					document.getElementById('displayaid').disabled = true;
                	document.getElementById('displaybalance').disabled = true;
				}
			}
        </script>
    </body>
</html>