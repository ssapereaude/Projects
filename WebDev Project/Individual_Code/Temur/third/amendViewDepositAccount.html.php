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
            <h1> View Deposit Account</h1>
            <h4>For which person would you like to view a deposit account? </h4>
            <p class="subjectboxtext">

    <form action="amendViewDepositAccount.html.php" method="POST"> <!-- This Form relates to the searchbar, upon searching the page is refreshed and the main form is populated -->

			<?php
                include "bankConnect.inc.php";
                session_start();
				
                $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE account.DeletedFlag=0 AND account.AccountType='deposit'";

                if(!$result = mysqli_query($con, $sql))
                    {
                        die('Oops...' . mysqli_error($con));
                    }
                echo"<br><select name='listbox' id='listbox' onclick='populate()'>";
                while($row = mysqli_fetch_array($result))
                    {
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
                        $alltext = "$customerid,$accountid,$firstname,$surname,$address,$eircode,$dateOfBirth,$telephone,$balance,$Amount";
                        echo"<option value = '$alltext'>$firstname $surname</option>";
                    }
                echo "</select>";
		mysqli_close($con);
                
            ?>
            <input style="width: 100px; margin-left:30px;" type="text" name="search" placeholder="CustomerID..." >  <!-- SearchBox -->
        <button type="submit">Search</button>    <!-- Search Button, populates main form upon clicking -->

    </form>

    <br>

    
    
    <form action="amendViewDepositAccount.html.php" method="POST"> <!-- This Form relates to the searchbar, upon searching the page is refreshed and the main form is populated -->
        <input style="width: 100px; margin-left:145px;" type="text" name="searchAccount" placeholder="AccountID..." >  <!-- SearchBox -->
        <button type="submit">Search</button>    <!-- Search Button, populates main form upon clicking -->
    </form>
    <?php
			include "bankConnect.inc.php";
                session_start();

    // This block of PHP relates to the Account ID search bar

    $accountID=null;   // AccountID initialized to null

    if(isset($_POST['searchAccount'])) 
    {
        $accountID=$_POST['searchAccount'];

        // This gets customer and account details

       
        $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE customer.DeletedFlag=0 AND AccountType='deposit' AND account.DeletedFlag=0 ";

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

        $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE customer.DeletedFlag=0 AND AccountType='deposit' AND account.DeletedFlag=0 ";

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
            <script>
                function populate()
                {
                    var sel = document.getElementById("listbox");
                    var result;
                    result = sel.options[sel.selectedIndex].value; //Take the value from the selected option in the listbox
                    var personDetails = result.split(','); //split the value at every comma
                    //Update form with details of selected person
					document.getElementById("showCID").value = personDetails[0];
                    document.getElementById("showID").value = personDetails[1];
                    document.getElementById("showFirstName").value = personDetails[2];
					document.getElementById("showLastName").value = personDetails[3];
					document.getElementById("showAddress").value = personDetails[4];
                    document.getElementById("showEircode").value = personDetails[5];
					document.getElementById("showDOB").value = personDetails[6];
					document.getElementById("showTelephone").value = personDetails[7];
					document.getElementById("showBalance").value = personDetails[8];
                    document.getElementById("showAmount").value = personDetails[9];

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
                            document.getElementById("showID").disabled = true;
                            document.getElementById("showFirstName").disabled = true;
                            document.getElementById("showLastName").disabled = true;
                            document.getElementById("showAddress").disabled = true;
                            document.getElementById("showEircode").disabled = true;
                            document.getElementById("showDOB").disabled = true;
                            document.getElementById("showTelephone").disabled = true;
                            document.getElementById("showBalance").disabled = true;
                            document.getElementById("showAmount").disabled = true;

                }
                

                function confirmDetails()
                {
                    var response;
                    response = confirm('Are you sure you want to save these changes?'); //Ask if user wants to save changes
                    if (response) //If the user says yes
                    {
                        //enable fields to be able to post them
                        document.getElementById("showID").disabled = false;
                        document.getElementById("showFirstName").disabled = false;
                        document.getElementById("showLastName").disabled = false;
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





<p id="display">

    <form id="myForm" action="amendViewDepositAccount.html.php" onload="lock()" onsubmit="return confirmCheck()" method="post">  
    <div class="inputbox">
    <label>Customer ID : </label>
    <input type="text" name="showCID" id="showCID" disabled placeholder="Customer ID">
    </div>	
    <div class="inputbox">
    <label>Account ID :</label>
    <input type="text" name="showID" id="showID" disabled placeholder="Account ID">
    </div>
    <div class="inputbox">
    <label>First Name : </label>
    <input type="text" name="showFirstName" id="showFirstName" disabled placeholder="First Name">
    </div>

    <div class="inputbox">
    <label>Last Name : </label>
    <input type="text" name="showLastName" id="showLastName" disabled placeholder="Last Name">
    </div>

    <div class="inputbox">
    <label>Address : </label>
    <input type="text" name="showAddress" id="showAddress" disabled placeholder="Address">
    </div>

    <div class="inputbox">
    <label>Eircode : </label>
    <input type="text" name="showEircode" id="showEircode" disabled placeholder="Eircode">
    </div>

    <div class="inputbox">
    <label>Date of Birth : </label>
    <input type="date" name="showDOB" id="showDOB" disabled placeholder="DOB">
    </div>

    <div class="inputbox">
    <label>Telephone : </label>
    <input type="text" name="showTelephone" id="showTelephone" disabled placeholder="Telephone">
    </div>


    <div class="inputbox">
    <label>Balance : </label>
    <input type="text" name="showBalance" id="showBalance" disabled placeholder="Balance">
    </div>

    <div class="inputbox">
    <label>Amount : </label>
    <input type="text" name="showAmount" id="showAmount" disabled placeholder="Amount">
    </div>

</form>
    <form action="DepositAccountHistory.php">
        <button type="submit">Save Changes</button>
    </form>

    </body>
</html>