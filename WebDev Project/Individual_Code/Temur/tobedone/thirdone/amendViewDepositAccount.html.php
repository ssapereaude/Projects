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
            <h1> View Deposit Account History</h1>
			<?php
                include "bankConnect.inc.php";
			   session_start();

				date_default_timezone_set("GMT");
				
                $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, depositaccount.AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE account.DeletedFlag=0 AND account.AccountType='deposit'";

                if(!$result = mysqli_query($con, $sql))
                    {
                        die('ERROR IN QUERYING THE DATABASE' . mysqli_error($con));
                    }
                echo"<br><div style='display: flex;'><select name='listbox' id='listbox' onclick='populate()'>";
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
                        $amount=$row['AmountRequested'];
                        $alltext = "$customerid,$firstname,$surname,$address,$eircode,$dateOfBirth,$telephone,$accountid,$balance,$amount";
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
					document.getElementById("amendamount").value = personDetails[9];
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
                    document.getElementById("showCID").disabled = true;
                            document.getElementById("amendcid").disabled = true;
                            document.getElementById("amendfname").disabled = true;
                            document.getElementById("amendsname").disabled = true;
                            document.getElementById("amendaddress").disabled = true;
                            document.getElementById("amendeircode").disabled = true;
                            document.getElementById("amenddob").disabled = true;
                            document.getElementById("amendtelephone").disabled = true;
                            document.getElementById("amendbalance").disabled = true;
                            document.getElementById("amendamount").disabled = true;
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
                        document.getElementById("amendamount").disabled = false;
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
			<form action="amendViewDepositAccount.html.php" onsubmit="return mySearch(0, 'search')" method="POST">
			          <input style="width: 100px; margin-left:30px;" type="text" id="search" name="search" placeholder="CustomerID..." >  <!-- SearchBox -->
        <button type="submit">Search</button>    <!-- Search Button, populates main form upon clicking -->

    </form>    
    
    <form action="amendViewDepositAccount.html.php" onsubmit="return mySearch(7, 'searchAccount')" method="POST"> <!-- This Form relates to the searchbar, upon searching the page is refreshed and the main form is populated -->
        <input style="width: 100px; margin-left:30px;" type="text" id="searchAccount" name="searchAccount" placeholder="AccountID..." >  <!-- SearchBox -->
        <button type="submit">Search</button>    <!-- Search Button, populates main form upon clicking -->
    </form>
			
	  </div>
	  <br>

    <script>
      function mySearch(criteriaIndex, inputId){
        const val = document.getElementById(inputId).value
        const listbox = document.getElementById("listbox")
		const options = listbox.children
		
		let i = 0;
		let selectedIndex = -1
		
		while(i < options.length){
			if(options[i].value.split(",")[criteriaIndex]==val){
				selectedIndex = i
			}
			
			i++
		}
		  
		 if(selectedIndex != -1){
		 	listbox.selectedIndex = selectedIndex
			 populate()
		 }
		  else {
			container = document.getElementById('details');
			inputs = container.getElementsByTagName('input');
			  
			i = 0
			 while(i < inputs.length){
			 
				 inputs[i].value = ""
				 
				 i++
			 }
			  
			  document.getElementById("history").innerHTML = ""
			  
		  }
		  
		  document.getElementById(inputId).value = ""

        return false
      }
    </script>
    <?php
			include "bankConnect.inc.php";
                session_start();

    // This block of PHP relates to the Account ID search bar

    $accountID=null;   // AccountID initialized to null
 if(isset($_POST['searchAccount'])) 
    {
        $accountID=$_POST['searchAccount'];
		echo $accountID;

        // This gets customer and account details

       
        $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE customer.DeletedFlag=0 AND account.AccountType='Deposit' AND account.DeletedFlag=0 ";

        if (!$result=mysqli_query($con, $sql))
        {
            die( 'Error in querying the database'.mysqli_error($con));
        }

        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);

            // Fetching values from the database

            $customerid = $row['CustomerID'];
					$accountid = $row['AccountID'];
                        $firstname = $row['FirstName'];
                        $surname = $row['LastName'];
                        $address = $row['Address'];
                        $eircode = $row['Eircode'];
                        $dateOfBirth = $row['DOB'];
                        $telephone = $row['Telephone'];
                        $balance = $row['Balance'];
                        $Amount = $row['AmountRequested'];

        }

        else 
        {
            // Handle case when no results are found
            $firstname = $accountid= $surname = $address = $eircode = $dateOfBirth = $telephone = $balance = $Amount = "";
        }
    }
			mysqli_close($con);
?>

<?php
			include "bankConnect.inc.php";
                session_start();

    // This block of PHP relates to the customer ID search bar

    $customerID=null;   // CustomerID initialized to null
	  
    if(isset($_POST['search'])) 
    {
        $customerID=$_POST['search'];

        // This gets customer and account details

        $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE customer.DeletedFlag=0 AND account.AccountType='Deposit' AND account.DeletedFlag=0 ";

        if (!$result=mysqli_query($con, $sql))
        {
            die( 'Error in querying the database'.mysqli_error($con));
        }

        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);

            // Fetching values from the database

            $customerid = $row['CustomerID'];
					$accountid = $row['AccountID'];
                        $firstname = $row['FirstName'];
                        $surname = $row['LastName'];
                        $address = $row['Address'];
                        $eircode = $row['Eircode'];
                        $dateOfBirth = $row['DOB'];
                        $telephone = $row['Telephone'];
                        $balance = $row['Balance'];
                        $Amount = $row['AmountRequested'];

        }

        else 
        {
            // Handle case when no results are found
            $firstname = $accountid= $surname = $address = $eircode = $dateOfBirth = $telephone = $balance = $Amount = "";
        }
    }
			mysqli_close($con);
?>
			

          <form id="display" class="inputbox">
                <label for="amendid">Your Account ID</label>
                <input type="text" name="amendid" id="amendid"  disabled placeholder="Account ID">
			<br><br>
                <label for="amendcid">Your Customer ID</label>
                <input type="text" name="amendcid" id="amendcid" disabled placeholder="Customer ID">
				<br><br>
                <label for="amendfname">Your First Name</label>
                <input type="text" name="amendfname" id="amendfname" disabled placeholder="First Name">
				<br><br>
                <label for="amendsname">Your Surname</label>
                <input type="text" name="amendsname" id="amendsname" disabled placeholder="Surname">
				<br><br>
                <label for="amendaddress">Your Address</label>
                <input type="text" name="amendaddress" id="amendaddress" disabled placeholder="Address">
				<br><br>
                <label for="amendeircode">Your Eircode</label>
                <input type="text" name="amendeircode" id="amendeircode" disabled placeholder="Eircode">
				<br><br>
                <label for="amenddob">Your Date of Birth</label>
                <input type="date" name="amenddob" id="amenddob" disabled placeholder="Date of Birth">
				<br><br>
                <label for="amendtelephone">Your Telephone</label>
                <input type="text" name="amendtelephone" id="amendtelephone" disabled placeholder="Telephone">
				<br><br>
				<label for="amendbalance">Your Expected Balance</label>
                <input type="text" name="amendbalance" id="amendbalance" disabled placeholder="Balance">
				<br><br>
				<label for="amendoverdraft">Your Amount</label>
                <input type="text" name="amendamount" id="amendamount" disabled placeholder="Amount">
                <br><br>
                <button type="submit">Save Changes</button>
            </form>
		</div>
		<div class="subjectbox">
			<h1>Transaction History</h1>
            <h4>Previous Transactions</h4>
			<div id="history">
			
		</div>
		</div>
    </body>
</html>