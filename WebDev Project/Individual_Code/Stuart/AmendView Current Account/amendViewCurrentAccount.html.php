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
            <h1> Amend/View a Person</h1>
            <h4>Please select a current account, and then click the amend button if you wish to update details.</h4>
			<?php
                include "bankConnect.inc.php";
				date_default_timezone_set("GMT");
				
                $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, currentaccount.OverdraftLimit FROM ((customer INNER JOIN account ON customer.CustomerID = account.CustomerID) INNER JOIN currentaccount ON account.AccountID = currentaccount.AccountID) WHERE account.DeletedFlag=0 AND account.AccountType='current'";

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
                        $telephone = $row['Telephone'];
                        $accountid = $row['AccountID'];
                        $balance = $row['Balance'];
						$overdraft = $row['OverdraftLimit'];
                        $alltext = "$customerid,$firstname,$surname,$address,$eircode,$dateOfBirth,$telephone,$accountid,$balance,$overdraft";
                        echo"<option value = '$alltext'>$firstname $surname</option>";
                    }
                echo "</select>";
                mysqli_close($con);
            ?>
            <script>
                function populate()
                {
                    var sel = document.getElementById("listbox");
                    var result;
                    result = sel.options[sel.selectedIndex].value; //Take the value from the selected option in the listbox
                    var personDetails = result.split(','); //split the value at every comma
                    //Update form with details of selected person
					document.getElementById("amendcid").value = personDetails[0];
                    document.getElementById("amendfname").value = personDetails[1];
                    document.getElementById("amendsname").value = personDetails[2];
					document.getElementById("amendaddress").value = personDetails[3];
					document.getElementById("amendeircode").value = personDetails[4];
                    document.getElementById("amenddob").value = personDetails[5];
					document.getElementById("amendtelephone").value = personDetails[6];
					document.getElementById("amendid").value = personDetails[7];
					document.getElementById("amendbalance").value = personDetails[8];
					document.getElementById("amendoverdraft").value = personDetails[9];
					//AJAX, or Asynchronous Javascript And XML
					var AJAX = new XMLHttpRequest();
					AJAX.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200)
							{
								document.getElementById("history").innerHTML = this.responseText;
							}
					};
					AJAX.open("POST", "fetchTransactions.php");
					var postID = "accountid=" + encodeURIComponent(personDetails[7]);
					//Sets the request header to specify the data sent in the send method. used with post.
					AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					AJAX.send(postID);
                }

                function toggleLock()
                {
                    if (document.getElementById("amendViewButton").value == "Amend Details") // If the user wishes to amend the details
                        {
                            //enable the editable fields
                            document.getElementById("amendoverdraft").disabled = false;
                            //Change button to View Details
                            document.getElementById("amendViewButton").value = "View Details";
                        }
                    else //If the user wishes to view the details
                        {
                            //disable editable fields
                            document.getElementById("amendoverdraft").disabled = true;
                            //Change button to Amend Details
                            document.getElementById("amendViewButton").value = "Amend Details";
                        }
                }

                function confirmDetails()
                {
                    var response;
                    response = confirm('Are you sure you want to save these changes?'); //Ask if user wants to save changes
                    if (response) //If the user says yes
                    {
                        //enable fields to be able to post them
                        document.getElementById("amendid").disabled = false;
                        document.getElementById("amendfname").disabled = false;
                        document.getElementById("amendsname").disabled = false;
                        document.getElementById("amendoverdraft").disabled = false;
                        return true;
                    }
                    else //if user says no
                    {
                        //repopulate to undo any changes
                        populate();
                        //relock the fields
                        toggleLock();
                        return false;
                    }
                }
            </script>
            <p id="amend"></p>
			<form action="amendViewCurrentAccount.html.php" method="post">
				<label for="search">Search By ID</label>
				<input type="number" name="search" id="search">
                <input type="radio" id="customerID" name="selection" value="CustomerID" checked>
                Customer ID
                <input type="radio" id="accountID" name="selection" value="AccountID">
                Account ID
				<button type="submit">Search Customers</button>
			</form>
            <input type="button" value="Amend Details" id="amendViewButton" onclick="toggleLock()">

            <form name="myForm" class="customerDetails" action="currentAccountAmended.html.php" onsubmit="return confirmDetails()" method="post">
                <label for="amendid">Account ID</label>
                <input type="number" name="amendid" id="amendid" disabled placeholder="Account ID">
                <label for="amendcid">Customer ID</label>
                <input type="number" name="amendcid" id="amendcid" disabled placeholder="Customer ID">
                <label for="amendfname">First Name</label>
                <input type="text" name="amendfname" id="amendfname" disabled placeholder="First Name">
                <label for="amendsname">Surname</label>
                <input type="text" name="amendsname" id="amendsname" disabled placeholder="Surname">
                <label for="amendaddress">Address</label>
                <input type="text" name="amendaddress" id="amendaddress" disabled placeholder="Address">
                <label for="amendeircode">Eircode</label>
                <input type="text" name="amendeircode" id="amendeircode" disabled placeholder="Eircode">
                <label for="amenddob">Date of Birth</label>
                <input type="date" name="amenddob" id="amenddob" disabled placeholder="Date of Birth">
                <label for="amendtelephone">Telephone</label>
                <input type="text" name="amendtelephone" id="amendtelephone" disabled placeholder="Telephone">
				<label for="amendbalance">Balance</label>
                <input type="text" step="0.01" name="amendbalance" id="amendbalance" disabled placeholder="Balance">
				<label for="amendoverdraft">Overdraft Limit</label>
                <input type="text" name="amendoverdraft" id="amendoverdraft" disabled placeholder="Overdraft Limit">
                <br><br>
                <button type="submit">Save Changes</button>
            </form>
		</div>
		<div class="subjectbox">
			<h1>Transaction History</h1>
            <h4>Previous Transactions</h4>
			<div id="history">
			
		<?php
		    include	"bankConnect.inc.php";
			date_default_timezone_set("GMT");
			if (isset($_POST["search"]) && $_POST["search"] != null)
				{
					$search = $_POST["search"];
                    if ($_POST["selection"] == "CustomerID")
                        {
                            $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, currentaccount.OverdraftLimit FROM ((customer INNER JOIN account ON customer.CustomerID = account.CustomerID) INNER JOIN currentaccount ON account.AccountID = currentaccount.AccountID) WHERE account.DeletedFlag=0 AND account.AccountType='current' AND customer.CustomerID = $search";
                        }
                    else
                        {
                            $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, currentaccount.OverdraftLimit FROM ((customer INNER JOIN account ON customer.CustomerID = account.CustomerID) INNER JOIN currentaccount ON account.AccountID = currentaccount.AccountID) WHERE account.DeletedFlag=0 AND account.AccountType='current' AND account.AccountID = $search";
                        }
					if(!$result = mysqli_query($con, $sql))
                        {
                            die('ERROR IN QUERYING THE DATABASE' . mysqli_error($con));
                        }
					if ($row = mysqli_fetch_array($result))
						{
							echo "
							<script>
								document.getElementById('amend').innerHTML = '';
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
							$overdraft = $row['OverdraftLimit'];
                        	$alltext = "'$customerid,$firstname,$surname,$address,$eircode,$dob,$telephone,$accountid,$balance,$overdraft'";
							echo"
							<script>
								var result = $alltext;
								var customerDetails = result.split(',');
                				document.getElementById('amendcid').value = customerDetails[0];
                				document.getElementById('amendfname').value = customerDetails[1];
                				document.getElementById('amendsname').value = customerDetails[2];
                				document.getElementById('amendaddress').value = customerDetails[3];
                				document.getElementById('amendeircode').value = customerDetails[4];
                				document.getElementById('amenddob').value = customerDetails[5];
                				document.getElementById('amendtelephone').value = customerDetails[6];
                                document.getElementById('amendid').value = customerDetails[7];
                                document.getElementById('amendbalance').value = customerDetails[8];
								document.getElementById('amendoverdraft').value = customerDetails[9];
							</script>";
							include("fetchTransactions.php");
						}
					else
						{
							echo
							"
							<script>
							document.getElementById('amend').innerHTML = 'The $_POST[selection] $search was not found.';
							</script>
							";
						};
				}
		?>
		</div>
		</div>
    </body>
</html>