<!-- Name : Temur Rustamov
 Number : C00280204
 Description : Close Deposit Account -->

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
<!-- php part -->
<script src="cda.js"></script> 

<div class="subjectbox">
    <h1>Close Deposit Account Page</h1>
    <p class="subjectboxtext">

        <form action="cda.php" method="POST">  

            <?php
			//connecting to db
            include "bankConnect.inc.php";
            session_start();
//getting values form db
                $sql = "SELECT customer.CustomerID, FirstName, LastName, Address, Eircode, DOB, Telephone, AccountID, Balance FROM customer INNER JOIN account ON customer.CustomerID=account.CustomerID WHERE customer.DeletedFlag=0 AND AccountType='deposit' AND account.DeletedFlag=0";

                if (!$result=mysqli_query($con, $sql))
                {
                    die( 'Error!'.mysqli_error($con)); //testing
                }

                echo "<select name='listbox' id='listbox' onclick='populate()'>";  //populating with data got from db

                while ($row=mysqli_fetch_array($result))   
                {
					// assigning data from db to the declared variables
                    $CustomerID = $row['CustomerID'];   
                    $FirstName = $row['FirstName'];
                    $LastName = $row['LastName'];
                    $Address  = $row['Address'];
                    $Eircode = $row['Eircode'];
                    $dateOfBirth = $row['DOB'];
                    $DOB = date_create($row['DOB']);
                    $DOB = date_format($DOB, "Y-m-d");
                    $Telephone = $row['Telephone'];
                    $AccountID = $row['AccountID'];
                    $Balance = $row['Balance'];



                    $allText = "$CustomerID, $FirstName, $LastName, $Address, $Eircode, $DOB, $Telephone, $AccountID, $Balance";
                    echo "<option value = '$allText'>$FirstName $LastName</option>";    
                }
                echo "</select>";
            ?>

        
            <input style="width: 200px; margin-left:50px;" type="text" name="search" placeholder="CustomerID" > 
            <button type="submit">Let's search!</button>    <!--search button-->

        </form>

        <?php

            $customerID=null;   //assigning null first of all to customer id
            
            if(isset($_POST['search'])) //if true
            {
                $customerID=$_POST['search']; //assigning to the variable 
                 
                $sql = "SELECT customer.CustomerID, FirstName, LastName, Address, Eircode, DOB, Telephone, AccountID, Balance FROM customer INNER JOIN account ON customer.CustomerID=account.CustomerID WHERE customer.DeletedFlag=0 AND customer.CustomerID='$customerID' AND AccountType='deposit' AND account.DeletedFlag=0"; //sql statement to get the data 

                if (!$result=mysqli_query($con, $sql))
                {
                    die( 'Error!'.mysqli_error($con)); //testing
                }

                if (mysqli_num_rows($result) > 0) 
                {
                    $row = mysqli_fetch_assoc($result);
					//assigning data to the declared variables

                    $CustomerID = $row['CustomerID'];
                    $FirstName = $row['FirstName'];
                    $LastName = $row['LastName'];
                    $Address  = $row['Address'];
                    $Eircode = $row['Eircode'];
                    $DOB = date('Y-m-d', strtotime($row['DOB']));
                    $Telephone = $row['Telephone'];
                    $AccountID = $row['AccountID'];
                    $Balance = $row['Balance'];
                }

                else 
                {
                    $CustomerID = $FirstName = $LastName = $Address = $Eircode = $DOB = $Telephone = $AccountID = $Balance = "";
                }

                mysqli_close($con); 
            }
            
        ?>
<!-- html part display form -->
    <p id="display">
        <form id="myForm" action="ccda.php" onload="lock()" onsubmit="return confirmDelete()" method="POST">   

            <div class="inputbox">
                <label>Your Customer ID </label>
                <input type="text" name="showID" id="showID" disabled value="<?php echo $CustomerID; ?>">
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
                <label>Your Eircode</label>
                <input type="text" name="showEircode" id="showEircode" disabled value="<?php echo $Eircode; ?>">
            </div><br>
            
            <div class="inputbox">
                <label>Your Date of Birth</label>
                <input type="date" name="showDOB" id="showDOB" disabled value="<?php echo $DOB; ?>">
            </div><br>
            
            <div class="inputbox">
                <label>Your Telephone Number</label>
                <input type="text" name="showTelephone" id="showTelephone" disabled value="<?php echo $Telephone; ?>">
            </div><br>

            <div class="inputbox">
                <label>Your Account ID</label>
                <input type="text" name="showAccountID" id="showAccountID" disabled value="<?php echo $AccountID; ?>">
            </div><br>

            <div class="inputbox">
                <label>Balance : </label>
                <input type="text" name="showBalance" id="showBalance" disabled value="<?php echo $Balance; ?>">
            </div>

            <input class="myButton" type="submit" value="Confirm">

        </form>
</div>
</body>
</html> 