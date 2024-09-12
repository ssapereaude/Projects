<!--Student Name: Isaiah Andres
Student Number: C00286361
Date:21/03/2024 -->
<!--Form for the user to see customer details if they choose an option from the listbox-->    
<?php include 'menu.php' ?>

<fieldset>

<?php include "bankConnect.inc.php";
$input = 1;
$fname = null;
$lname = null;
$address = null;
$custID = null;
$accID = null;
$balance = null;
$accType = null;
$customerRowcount = 1;
$accountRowcount = 1;

//----- Customer SearchBar -----//
if(ISSET($_POST['searchCustomer'])) //Checks if the search customer submit button has been clicked on
{
$input = $_POST['customerID'];
if($input == null)
{
    echo "No customer ID was searched for";
}
else
{
    $sql = "SELECT FirstName, LastName, Address, customer.CustomerID, AccountID, Balance FROM customer 
    INNER JOIN account ON customer.CustomerID = account.CustomerID 
    WHERE customer.DeletedFlag = 0 AND customer.CustomerID = $input"; //MySQL query to select the customer details

    /*SELECT FirstName, LastName, Address, customer.CustomerID, AccountID, Balance, AccountType FROM customer
    INNER JOIN account ON customer.CustomerID = account.CustomerID WHERE customer.DeletedFlag = 0 AND account.CustomerID = 2 AND (AccountType = 'deposit' OR AccountType = 'loan' OR AccountType = 'current'); */

    if (!$result = mysqli_query($con,$sql))
    {
    die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
    }

    while ($row = mysqli_fetch_array($result)) //fetches the results of the MySQL query as an associative array
    {
    $fname = $row['FirstName'];
    $lname = $row['LastName'];
    $address = $row['Address'];
    $custID = $row['CustomerID'];
    $accID = $row['AccountID'];
    $balance = $row['Balance'];
    }
    $customerRowcount =mysqli_num_rows($result);
    }

    //Code for showing the details of the current account using the CustomerID search function
    $sqlCustomerCurrentAccountCheck = " SELECT OverdraftLimit, Balance FROM currentaccount INNER JOIN account ON account.AccountID = currentaccount.AccountID INNER JOIN customer ON customer.CustomerID = account.CustomerID WHERE customer.CustomerID  = $input AND AccountType = 'current'";
    if (!$customerCurrentAccountResult = mysqli_query($con,$sqlCustomerCurrentAccountCheck))
    {
    die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
    }

    if(!$customerCurrentAccountRow = mysqli_fetch_array($customerCurrentAccountResult))
    {
        echo "<div class = currentAccountDetails>";
        echo "<br><span>The Customer Does Not Have a Current Account</span><br>";
        echo "</div>";
    }
    else// SELECT OverdraftLimit, Balance FROM currentaccount INNER JOIN account ON account.AccountID = currentaccount.AccountID INNER JOIN customer ON customer.CustomerID = account.CustomerID WHERE customer.CustomerID  = '2' AND AccountType = 'current';
    {
        $sqlCurrentAccountID = "SELECT AccountID FROM account WHERE CustomerID = '$custID' AND AccountType = 'current'";
        if (!$resultCurrentID = mysqli_query($con,$sqlCurrentAccountID))
        {
        die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
        }
        $currentAccountIDRow = mysqli_fetch_array($resultCurrentID);
        echo "<div class = currentAccountDetails>";
        echo "<span>Overdraft Limit for Current Account:</span> " . $customerCurrentAccountRow[0]; 
        echo "<br><span>Balance For Current Account:</span> " . $customerCurrentAccountRow[1];
        echo "<br><br><button value='$currentAccountIDRow[AccountID]' id='lodgeCurrentButton' name = 'cAccountButton' onclick='chooseCurrent()'>Lodge To Current Account</button><br>";
        echo "</div>";
    }

    $sqlCustomerDepositAccountCheck = " SELECT AmountRequested, Balance FROM depositaccount INNER JOIN account ON account.AccountID = depositaccount.AccountID INNER JOIN customer ON customer.CustomerID = account.CustomerID WHERE customer.CustomerID = $input AND AccountType = 'Deposit'";
    if (!$customerDepositAccountResult = mysqli_query($con,$sqlCustomerDepositAccountCheck))
    {
    die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
    }
    if(!$customerDepositAccountRow = mysqli_fetch_array($customerDepositAccountResult))
    {
        echo "<div class = depositAccountDetails>";
        echo "<br><span>The Customer Does Not Have a Deposit Account</span><br>" ;
        echo "</div>";
    }
    else
    {
        $sqlDepositAccountID = "SELECT AccountID FROM account WHERE CustomerID = '$custID' AND AccountType = 'Deposit'";
        if (!$resultDepositID = mysqli_query($con,$sqlDepositAccountID))
        {
        die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
        }
        $depositAccountIDRow = mysqli_fetch_array($resultDepositID);
        echo "<div class = depositAccountDetails>";
        echo "<span>Amount Requested for Deposit Account:</span> " . $customerDepositAccountRow[0];
        echo "<br><span>Balance for Deposit Account:</span>  " . $customerDepositAccountRow[1];
        echo "<br><br><button value='$depositAccountIDRow[AccountID]' id='lodgeDepositButton' onclick='chooseDeposit()'>Lodge To Deposit Account</button><br>";
        echo "</div>";
    }   

    $sqlCustomerLoanAccountCheck = " SELECT AmountRequested, Term, MonthlyRepayments, Balance FROM loanaccount INNER JOIN account ON account.AccountID = loanaccount.AccountID INNER JOIN customer ON customer.CustomerID = account.CustomerID WHERE customer.CustomerID = $input AND AccountType = 'Loan'";
    if (!$customerLoanAccountResult = mysqli_query($con,$sqlCustomerLoanAccountCheck))
    {
    die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
    }

    if(!$customerLoanAccountRow = mysqli_fetch_array($customerLoanAccountResult))
    {
        echo "<div class = loanAccountDetails>";
        echo "<span>The Customer Does Not Have a Loan Account</span>";
        echo "</div>";
    }
    else
    {
        $sqlLoanAccountID = "SELECT AccountID FROM account WHERE CustomerID = '$custID' AND AccountType = 'Loan'";
        if (!$resultLoanID = mysqli_query($con,$sqlLoanAccountID))
        {
        die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
        }
        echo "<div class = loanAccountDetails>";
        echo "<span>Amount Requested for Loan Account:</span> " . $customerLoanAccountRow[0];
        echo "<span><br>Term for Loan Account:</span> " . $customerLoanAccountRow[1];
        echo "<span><br>MonthlyRepayments for Loan Account:</span> " . $customerLoanAccountRow[2];
        echo "<br><span>Balance for Loan Account:</span> " . $customerLoanAccountRow[3];
        $customerLoanIDRow = mysqli_fetch_array($resultLoanID); 
        echo "<br><br><button value='$customerLoanIDRow[AccountID]' id='lodgeLoanButton' onclick='chooseLoan()'>Lodge To Loan Account</button><br>";
        echo "</div>";
    }
}

if($customerRowcount == 0)
{
    echo "<span>The Customer ID that has been searched for doesn't exist</span>" . "<br><br> ";
}
//----- Account SearchBar -----//
if(ISSET($_POST['searchAccount'])) //Checks if the search customer submit button has been clicked on
{
$input = $_POST['accountID'];
if($input == null)
{
    echo "<span>No account ID was searched for</span><br>";
}
else
{
//Block of code that shows the customer details from the account
$sql = "SELECT FirstName, LastName, Address, customer.CustomerID, AccountID, Balance, AccountType FROM customer 
INNER JOIN account ON customer.CustomerID = account.CustomerID 
WHERE customer.DeletedFlag = 0 AND account.AccountID = $input"; //MySQL query to select the customer details

if (!$result = mysqli_query($con,$sql))
{
die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
}

while ($row = mysqli_fetch_array($result)) //fetches the results of the MySQL query as an associative array
{
$fname = $row['FirstName'];
$lname = $row['LastName'];
$address = $row['Address'];
$custID = $row['CustomerID'];
$accID = $row['AccountID'];
$balance = $row['Balance'];
$accType = $row['AccountType'];
}
$accountRowcount = mysqli_num_rows($result);
if($accountRowcount == 0)
{
    echo "The Account ID that has been searched for doesn't exist " . "<br><br> ";
}
}
}
?>
    <legend><h1>Lodge Money Into An Account</h1></legend>
    Choose a customer or account to lodge money into by name, customer ID or account ID
    <br>
    <div class="amendBox">
    <form action = "CustomerLodgement.php" method = "POST" > <!--Submitting the form to the current page as trying to submit the details to another php file to be handled takes it to the corresponding page -->
    <div>
    <label for="customerID">Customer ID:</label>
    <input type="text" name="customerID" id="customerID" /> <!--Using this rather than numbers shows a calendar in which dates can chosen from -->
    </div>
    <div>
    <div class="searchCustomer">
    <input type="submit" value="Search" name="searchCustomer" onclick = "checkSearch()"/><!-- Search Button for customers-->
    </form>

    <form action = "CustomerLodgement.php" method = "POST" > <!--Submitting the form to the current page as trying to submit the details to another php file to be handled takes it to the corresponding page -->
    <div>
    <label for="accountID">Account ID:</label>
    <input type="text" name="accountID" id="accountID" /> <!--Using this rather than numbers shows a calendar in which dates can chosen from -->
    </div>
    <div>
    <div class="searchAccount">
    <input type="submit" value="Search" name="searchAccount" onclick = "checkSearch()"/><!-- Search Button for accounts-->
    </form>

    <br> <!--Main Form-->
    <form action = "lodgements.php" method = "POST" name = "accountForm" >
    <div class="fname">
    <label for="name">Customer First Name:</label> <!-- Input box for the first name-->
    <input type="text" name="fnameID" id="fnameID"  autofocus disabled value = "<?php echo $fname;?>"/>
    </div>
    <div class="lname">
    <label for="name">Customer Surname:</label> <!-- Input box for the last name-->
    <input type="text" name="lnameID" id="lnameID"  disabled value = "<?php echo $lname; ?>"/>
    </div>
    <div class="address">
    <label for="address">Customer Address:</label>
    <input type="text" name="addressID" id="addressID" disabled value = "<?php echo $address; ?>"/> <!-- input box for the address-->
    </div>
    <div class="customerID">
    <label for="custID">Customer ID:</label> <!-- Input box for the first name-->
    <input type="text" name="custID" id="custID" disabled value = "<?php echo $custID; ?>"/> <!--Has to be enabled in order to post it's information. Use JS to set it to enabled if the confirm option is true -->
    </div>
    <div class="accountID">
    <label for="accID">Account ID:</label> <!-- Input box for the first name-->
    <input type="text" name="accID" id="accID" disabled value = "<?php echo $accID; ?>"/> <!-- Has to be enabled in order to post it's information. Use JS to set it to enabled if the confirm option is true -->
    </div>
    <div class="accountUsed">
    <label for="balance">Account To Make Lodgement:</label> <!-- Input box for the first name-->
    <input type="text" name="accountUsedID" id="accountUsedID" disabled value = "<?php echo $accType; ?>"/> <!--Has to be enabled in order to post it's information. Use JS to set it to enabled if the confirm option is true -->
    </div>
    <div class="lodgement">
    <label for="lodgement">Lodgement Amount:</label> <!-- Input box for the first name-->
    <input type="number" name="lodgementID" id="lodgementID" step = "0.01" /> <!--Has to be enabled in order to post it's information. Use JS to set it to enabled if the confirm option is true -->
    </div>
    <div class="submitDetails">
    <input type="submit" value="Send Form" name="submit" onclick="confirmLodgement()"/><br><br> <!-- Submit Button onclick="confirmChoices()" -->
	</div>
    </form>
    <div class = "customerListbox">
    <?php include 'customerListbox.php'; ?> <!--Placing the listbox at the bottom as putting it near the top causes issues -->
    </div>
    </fieldset>

</body>
</html>