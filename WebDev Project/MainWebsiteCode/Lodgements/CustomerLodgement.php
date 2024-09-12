<!--
Name Of Screen: CustomerLodgement
Purpose Of Screen: Provides form to show customer and account information and to choose which customer's account to lodge money into 

Student Name: Isaiah Andres
Student Number: C00286361
Date:31/03/2024 -->


<!--Form for the user to see customer details if they choose an option from the listbox-->  
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="stylesheet" href="/MainWebsiteCode/MainStyling.css">
		<script type="text/javascript" src="LodgementScreenFunctions.js" ></script>
        <title>Make A Lodgement</title>
    </head>
    <body>
<?php include '/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/MainMenu.php'; ?>

<fieldset class = "fieldsetCustomer">

<?php include "bankConnect.inc.php";
$input = 1; //Initialising variables as they would show errors in the input boxes otherwise
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
    if($input == null) //Checking if an ID sent and the following message will appear
    {
        echo "No customer ID was searched for";
    }
    else
    {
        $sql = "SELECT FirstName, LastName, Address, customer.CustomerID, AccountID, Balance FROM customer 
        INNER JOIN account ON customer.CustomerID = account.CustomerID 
        WHERE customer.DeletedFlag = 0 AND customer.CustomerID = $input"; //MySQL query to select the customer details according to the ID

        if (!$result = mysqli_query($con,$sql))
        {
            die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
        }

        while ($row = mysqli_fetch_array($result)) //fetches the results of the MySQL query as an associative array and assigns them to variables
        {
            $fname = $row['FirstName'];
            $lname = $row['LastName'];
            $address = $row['Address'];
            $custID = $row['CustomerID'];
            $accID = $row['AccountID'];
            $balance = $row['Balance'];
        }
        $customerRowcount =mysqli_num_rows($result); //Assigning the number of rows returned to a variable
    }

        //Code for showing the details of the current account using the CustomerID search function
        $sqlCustomerCurrentAccountCheck = " SELECT OverdraftLimit, Balance FROM currentaccount INNER JOIN account ON account.AccountID = currentaccount.AccountID 
        INNER JOIN customer ON customer.CustomerID = account.CustomerID WHERE customer.CustomerID  = $input AND AccountType = 'current'"; //MySQL Query to select the overdraft limit and balance through the use of an inner join between the account and currentaccount table
        if (!$customerCurrentAccountResult = mysqli_query($con,$sqlCustomerCurrentAccountCheck)) //Statement executed here
        {
            die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
        }

        if(!$customerCurrentAccountRow = mysqli_fetch_array($customerCurrentAccountResult)) 
        {
            echo "<div class = currentAccountDetails>";
            echo "<br><span class = 'accountDetailText'>The Customer Does Not Have a Current Account</span><br>"; //Message that appears if no array was returned implying that the customer doesn't have a current account
            echo "</div>";
        }
        else
        {
            $sqlCurrentAccountID = "SELECT AccountID FROM account WHERE CustomerID = '$custID' AND AccountType = 'current'"; //MySQL query to retrieve the current account ID
            if (!$resultCurrentID = mysqli_query($con,$sqlCurrentAccountID))
            {
                die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
            }
            $currentAccountIDRow = mysqli_fetch_array($resultCurrentID);
            echo "<div class = currentAccountDetails>";
            echo "<span class = 'accountDetailText'>Overdraft Limit for Current Account:</span> " . $customerCurrentAccountRow[0]; //Displaying the current account details taken from the first sql statement
            echo "<br><span class = 'accountDetailText'>Balance For Current Account:</span> " . $customerCurrentAccountRow[1];
            echo "<br><br><button value='$currentAccountIDRow[AccountID]' id='lodgeCurrentButton' name = 'cAccountButton' onclick='chooseCurrent()'>Lodge To Current Account</button><br>"; //Button with the current account ID as its value to use with the javascript function
            echo "</div>";
        }

        $sqlCustomerDepositAccountCheck = " SELECT AmountRequested, Balance FROM depositaccount 
        INNER JOIN account ON account.AccountID = depositaccount.AccountID INNER JOIN customer ON customer.CustomerID = account.CustomerID WHERE customer.CustomerID = $input AND AccountType = 'Deposit'"; //MySQL Query to select the Amount Requested and balance through the use of an inner join between the account and depositaccount table
        if (!$customerDepositAccountResult = mysqli_query($con,$sqlCustomerDepositAccountCheck)) //
        {
            die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
        }
        if(!$customerDepositAccountRow = mysqli_fetch_array($customerDepositAccountResult))
        {
            echo "<div class = depositAccountDetails>";
            echo "<br><span class = 'accountDetailText'>The Customer Does Not Have a Deposit Account</span><br>" ; //Message that appears if no array was returned implying that the customer doesn't have a deposit account
            echo "</div>";
        }
        else
        {
            $sqlDepositAccountID = "SELECT AccountID FROM account WHERE CustomerID = '$custID' AND AccountType = 'Deposit'"; //MySQL query to retrieve the Deposit account ID
            if (!$resultDepositID = mysqli_query($con,$sqlDepositAccountID))
            {
                die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
            }
            $depositAccountIDRow = mysqli_fetch_array($resultDepositID); //Message that appears if no array was returned implying that the customer doesn't have a deposit account
            echo "<div class = depositAccountDetails>";
            echo "<span class = 'accountDetailText'>Amount Requested for Deposit Account:</span> " . $customerDepositAccountRow[0]; //Displaying the deposit account details taken from the first sql statement
            echo "<br><span class = 'accountDetailText'>Balance for Deposit Account:</span>  " . $customerDepositAccountRow[1];
            echo "<br><br><button value='$depositAccountIDRow[AccountID]' id='lodgeDepositButton' onclick='chooseDeposit()'>Lodge To Deposit Account</button><br>"; //Button with the deposit account ID as its value to use with the javascript function
            echo "</div>";
        }   

        $sqlCustomerLoanAccountCheck = " SELECT AmountRequested, Term, MonthlyRepayments, Balance FROM loanaccount 
        INNER JOIN account ON account.AccountID = loanaccount.AccountID INNER JOIN customer ON customer.CustomerID = account.CustomerID WHERE customer.CustomerID = $input AND AccountType = 'Loan'"; //MySQL Query to select the Amount Requested and Term and Monthly Repayments and Balance through the use of an inner join between the account and loanaccount table
        if (!$customerLoanAccountResult = mysqli_query($con,$sqlCustomerLoanAccountCheck))
        {
            die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
        }

        if(!$customerLoanAccountRow = mysqli_fetch_array($customerLoanAccountResult))
        {
            echo "<div class = loanAccountDetails>";
            echo "<span class = 'accountDetailText'>The Customer Does Not Have a Loan Account</span>"; //Message that appears if no array was returned implying that the customer doesn't have a loan account
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
            echo "<span class = 'accountDetailText'>Amount Requested for Loan Account:</span> " . $customerLoanAccountRow[0]; //Displaying the loan account details taken from the first sql statement
            echo "<span class = 'accountDetailText'><br>Term for Loan Account:</span> " . $customerLoanAccountRow[1];
            echo "<span class = 'accountDetailText'><br>MonthlyRepayments for Loan Account:</span> " . $customerLoanAccountRow[2];
            echo "<br><span>Balance for Loan Account:</span> " . $customerLoanAccountRow[3];
            $customerLoanIDRow = mysqli_fetch_array($resultLoanID); 
            echo "<br><br><button value='$customerLoanIDRow[AccountID]' id='lodgeLoanButton' onclick='chooseLoan()'>Lodge To Loan Account</button><br>"; //Button with the loan account ID as its value to use with the javascript function
            echo "</div>";
        }
    }

    if($customerRowcount == 0) //Message that appears if the rows returned is 0
    {
        echo "<span class = 'accountDetailText'>The Customer ID that has been searched for doesn't exist</span>" . "<br><br> ";
    }
    //----- Account SearchBar -----//
    if(ISSET($_POST['searchAccount'])) //Checks if the search customer submit button has been clicked on
    {
    $input = $_POST['accountID'];
    if($input == null)
    {
        echo "<span class = 'accountDetailText'>No account ID was searched for</span><br>"; //If the input ID is null then it implies that no customer was searched for
    }
    else
    {
    //Block of code that shows the customer details from the account
    $sql = "SELECT FirstName, LastName, Address, customer.CustomerID, AccountID, Balance, AccountType FROM customer 
    INNER JOIN account ON customer.CustomerID = account.CustomerID 
    WHERE customer.DeletedFlag = 0 AND account.AccountID = $input"; //MySQL query to select the customer details according to the account ID through the use of an inner join

    if (!$result = mysqli_query($con,$sql))
    {
    die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
    }

    while ($row = mysqli_fetch_array($result)) //fetches the results of the MySQL query as an associative array and assigns them to variables
    {
    $fname = $row['FirstName'];
    $lname = $row['LastName'];
    $address = $row['Address'];
    $custID = $row['CustomerID'];
    $accID = $row['AccountID'];
    $balance = $row['Balance'];
    $accType = $row['AccountType'];
    }
    $accountRowcount = mysqli_num_rows($result); //Assigning the number of rows returned to a variable
    if($accountRowcount == 0)
    {
        echo "The Account ID that has been searched for doesn't exist " . "<br><br> ";   //Message that appears if the rows returned is 0
    }
    }
}
?>
    <h1>Lodge Money Into An Account</h1>
	<br>
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
    <input type="submit" value="Search" name="searchCustomer" /><!-- Search Button for customers-->
    </form>

    <form action = "CustomerLodgement.php" method = "POST" > <!--Submitting the form to the current page as trying to submit the details to another php file to be handled takes it to the corresponding page -->
    <div>
    <label for="accountID">Account ID:</label>
    <input type="text" name="accountID" id="accountID" /> <!--Using this rather than numbers shows a calendar in which dates can chosen from -->
    </div>
    <div>
    <div class="searchAccount">
    <input type="submit" value="Search" name="searchAccount" /><!-- Search Button for accounts-->
    </form>

    <br> <!--Main Form-->
    <form action = "lodgements.php" method = "POST" name = "accountForm" >
    <div class="fname">
    <label for="name">Customer First Name:</label> <!-- Input box for the first name-->
    <input type="text" name="fnameID" id="fnameID"  autofocus disabled value = "<?php echo $fname;?>"/> <!--Echoing the values returned by the account ID search to the corresponding input boxes -->
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