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
				
                $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName,account.AccountID, account.Balance, depositaccount.AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE account.DeletedFlag=0 AND account.AccountType='deposit'";

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
                       
                        $accountid = $row['AccountID'];
                        $balance = $row['Balance'];
                        $amount=$row['AmountRequested'];
                        $alltext = "$customerid,$firstname,$surname,$accountid,$balance,$amount";
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
					document.getElementById("cid").value = personDetails[0];
                    document.getElementById("fname").value = personDetails[1];
                    document.getElementById("sname").value = personDetails[2];
				
					document.getElementById("id").value = personDetails[3];
					document.getElementById("balance").value = personDetails[4];
					document.getElementById("amount").value = personDetails[5];
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
					var postID = "accountid=" + encodeURIComponent(personDetails[3]);
					//Sets the request header to specify the data sent in the send method. used with post.
					AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					AJAX.send(postID);
                }

                function toggleLock()
                {
                            document.getElementById("cid").disabled = true;
                            document.getElementById("fname").disabled = true;
                            document.getElementById("sname").disabled = true;
                            document.getElementById("balance").disabled = true;
                            document.getElementById("amount").disabled = true;
                }

                function confirmDetails()
                {
                    var response;
                    response = confirm('Are you sure you want to save these changes?'); //Ask if user wants to save changes
                    if (response) //If the user says yes
                    {
                        //enable fields to be able to post them
                        document.getElementById("id").disabled = false;
                        document.getElementById("fname").disabled = false;
                        document.getElementById("sname").disabled = false;
                        document.getElementById("amount").disabled = false;
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
    
    <form action="amendViewDepositAccount.html.php" onsubmit="return mySearch(3, 'searchAccount')" method="POST"> <!-- This Form relates to the searchbar, upon searching the page is refreshed and the main form is populated -->
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

        // This gets customer and account details

       
        $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName,account.AccountID, account.Balance, AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE customer.DeletedFlag=0 AND account.AccountType='Deposit' AND account.DeletedFlag=0 ";

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
                        
                        $balance = $row['Balance'];
                        $Amount = $row['AmountRequested'];

        }

        else 
        {
            // Handle case when no results are found
            $firstname = $accountid= $surname = $balance = $Amount = "";
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

        $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName,account.AccountID, account.Balance, AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE customer.DeletedFlag=0 AND account.AccountType='Deposit' AND account.DeletedFlag=0 ";

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
                        
                        $balance = $row['Balance'];
                        $Amount = $row['AmountRequested'];

        }

        else 
        {
            // Handle case when no results are found
            $firstname = $accountid= $surname = $balance = $Amount = "";
        }
    }
			mysqli_close($con);
?>
			

          <form id="display" class="inputbox">
                <label for="id">Your Account ID</label>
                <input type="text" name="id" id="id"  disabled placeholder="Account ID">
			<br><br>
                <label for="cid">Your Customer ID</label>
                <input type="text" name="cid" id="cid" disabled placeholder="Customer ID">
				<br><br>
                <label for="fname">Your First Name</label>
                <input type="text" name="fname" id="fname" disabled placeholder="First Name">
				<br><br>
                <label for="sname">Your Surname</label>
                <input type="text" name="sname" id="sname" disabled placeholder="Surname">
				<br><br>
				<label for="balance">Your Expected Balance</label>
                <input type="text" name="balance" id="balance" disabled placeholder="Balance">
				<br><br>
				<label for="amount">Your Amount</label>
                <input type="text" name="amount" id="amount" disabled placeholder="Amount">
                <br><br>
                <button type="submit">Save Changes</button>
            </form>

		</div>
		<div class="subjectbox">
			<h1>Deposit Account History</h1>
			<div id="history">
			
		</div>
		</div>
    </body>
</html>