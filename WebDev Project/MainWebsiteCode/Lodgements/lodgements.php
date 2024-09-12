<!--
Name Of Screen: Lodgements
Purpose Of Screen: Makes calculations to lodge money into each account type and updates the database and inserts the lodgement details to the transactions table
 
Student Name: Isaiah Andres
Student Number: C00286361
Date:31/03/2024
-->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="stylesheet" href="/MainWebsiteCode/MainStyling.css">
        <title>Make A Lodgement</title>
    </head>
    <body>
<?php include '/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/MainMenu.php'; ?>
<?php include '../bankConnect.inc.php' ?>
<br><br>
<div class = "ReportBox">
<?php  //Account for current date, lodgement , account type, name,
$fname = $_POST['fnameID'];
$lname = $_POST['lnameID'];
$accountUsed = $_POST['accountUsedID']; //Assignning posted values to variables 
$accountID = $_POST['accID'];
$customerID = $_POST['custID'];
$lodgement = $_POST['lodgementID'];

if($lodgement == null || $lodgement <= 0 || $customerID == null)
{
    echo "No lodgement was made"; //Message that appears if the lodgement is invalid, null or no customer ID was posted
}
else
{

    if($accountUsed == 'Loan')
    {
        $sqlLoanAccount = "SELECT AmountRequested, Term, MonthlyRepayments FROM loanaccount WHERE AccountID = '$accountID'";
        if (!$result = mysqli_query($con,$sqlLoanAccount))
        {
        die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
        }

        $loanAccountRow =  mysqli_fetch_array($result); 
        $amountRequested = $loanAccountRow['AmountRequested']; //Assigning values retrieved form the mysql statement to variables
        $term = $loanAccountRow['Term'];
        $monthlyRepayments = $loanAccountRow['MonthlyRepayments'];
        $fullRepayment = $term * $monthlyRepayments; //How much the bank is owed is calculated by the term multiplied by the repayments
        $newRepayment = $fullRepayment - $lodgement; //Subtracting the full repayment from the lodgement
        $newRoundedRepayment = round($newRepayment, 2);

        if($newRepayment >= 0) //If the balance is less than zero then money is still owed
        {
            $newTerm = $newRepayment/$monthlyRepayments; //Term
            $roundedNewTerm = (floor($newTerm)); //Rounding to the lowest whole number W3Schools
    //        $modNewTermDecimal = $newTerm - floor($newTerm);
    //        echo "<br><br>$modNewTermDecimal <br><br>";
            $newMonthlyRepayments = $newRoundedRepayment/$roundedNewTerm;
            $roundedMonthlyRepayments = round($newMonthlyRepayments, 2); //Rounding to two decimal places W3Schools how accurate must this be?

            $sqlUpdateLoan = "UPDATE loanaccount SET TERM = '$roundedNewTerm', MonthlyRepayments = '$roundedMonthlyRepayments' WHERE AccountID = '$accountID'"; //Updating the loan account details with the calculations in mind 
            if (!mysqli_query($con, $sqlUpdateLoan))
            {
                echo "Error ".mysqli_error($con); // Shows error if there is a problem with the MySQL statement or connection
            }
            else
            {
                if (mysqli_affected_rows($con) != 0) //Following code takes place if rows have been affected
            {
                $currentDateString = strtotime("today"); //Setting string to time to "today" will get the current date W3Schools
                $currentDate = date("Y-m-d", $currentDateString); //Formatting the date to "2000-12-12"
                echo " 
                <h1>Lodgement Report</h1> <br><br> 
                        Date: "; echo "$currentDate"; //Echoing html code that displays customer details
                echo    " &nbsp  &nbsp Customer Name: "; echo "$fname" . " " ."$lname <br><br>";
                echo    "Account Type: Loan Account <br>";
                echo    "Lodgement Made: "; echo "$lodgement euro <br><br>";
                echo    "Previous Term: "; echo "$term months<br>";
                echo    "Previous Monthly Repayment: "; echo "$monthlyRepayments euro<br>";
                echo    "New Term: "; echo "$roundedNewTerm months<br>";
                echo    "New Monthly Repayment "; echo "$roundedMonthlyRepayments euro<br><br>";
                
                $sqlGetBalance = "SELECT Balance FROM account WHERE AccountID = $accountID"; //MySQL query to retrieve the balance
                if (!$balanceResult=mysqli_query($con, $sqlGetBalance)) //Query is executed here
                {
                echo "Error ".mysqli_error($con); // Shows error if there is a problem with the MySQL statement or connection
                }
                $balanceRow = mysqli_fetch_array($balanceResult);
                $balance = $balanceRow['Balance']; //Getting the balance from the associative array
                $newBalance = $balance + $lodgement; //how much is owed affects balance so the lodgement adds to the balance since what's owed is reduced
                
                //mysql query that allows the user to insert the values from the html form to the database fields using POST 
                $sqlMax =  "SELECT MAX(TransactionID) AS maxID FROM transaction";
                $result = mysqli_query($con,$sqlMax); //mysql query that selects the highest value from the customer ID from the customer, calling it maxid allows for it to be entered to the row array as an index and to get the result  
                $row = mysqli_fetch_assoc($result); //Fetches the result row as an associative array or as a numerical array
                $maxID = $row['maxID']; //Assigning the row with maxID as its index to the variable $maxID
                $maxID++; //Increments the maxID to represent the next ID which is to be auto-incremented

                $sqlUpdateTransaction = "INSERT INTO transaction (TransactionID,AccountID, AccountType, Type, Amount, Date, Balance) 
                VALUES ('$maxID','$accountID', '$accountUsed', 'Lodgement', '$lodgement', '$currentDate', '$newBalance')"; //Adding the lodgement information to the transactions table
                if (!mysqli_query($con, $sqlUpdateTransaction)) //Query is executed here
                {
                    echo "Error ".mysqli_error($con); // Shows error if there is a problem with the MySQL statement or connection
                }
            }
            else
            {
                echo "No records were changed"; //If the number of affected rows is zero, this message is shown
            }
            }        

        }
        else //If the balance is greater than zero then no more money is owed and the rest of the money will be added to the balance
        {
            echo "You can't lodge more money than the full repayment";
        }
    } 
    ?>

    <?php
    if($accountUsed == 'current') //Lodgement made straight to the account's balance
    {
        $sqlGetBalance = "SELECT Balance FROM account WHERE AccountID = $accountID"; //MySQL query to retrieve the accounts balance
            if (!$balanceResult=mysqli_query($con, $sqlGetBalance)) //Query is executed here
            {
                echo "Error ".mysqli_error($con); // Shows error if there is a problem with the MySQL statement or connection
            }
            $balanceRow = mysqli_fetch_array($balanceResult); //Fetching the results of the query as an array
            $balance = $balanceRow['Balance']; //Getting the balance from the result row 
            $newBalance = $balance + $lodgement; //Getting the new balance of the account by adding the old balance and lodgement made

        $sqlUpdateCurrentAccount = "UPDATE account SET Balance = '$newBalance' WHERE AccountID = '$accountID'"; //Updating the account details
        if (!mysqli_query($con, $sqlUpdateCurrentAccount)) //Query is executed here
        {
            echo "Error ".mysqli_error($con); // Shows error if there is a problem with the MySQL statement or connection
        }
        else
        {
        
        if (mysqli_affected_rows($con) != 0) //Following code takes place if rows have been affected
        {
            $currentDateString = strtotime("today"); //Setting string to time to "today" will get the current date W3Schools
            $currentDate = date("Y-m-d", $currentDateString); //Formatting the date to "2000-12-12"

            echo "
            <h1>Lodgement Report</h1> <br><br> 
                    Date: "; echo $currentDate;
            echo    " &nbsp  &nbsp Customer Name: "; echo "$fname" . " " ."$lname <br><br>"; //Echoing html code to display the lodgement details
            echo    "Account Type: Current Account <br>";
            echo    "Lodgement Made: "; echo "$lodgement euro <br><br>";
            echo    "Previous Balance: "; echo "$balance <br><br>";
            echo    "New Balance: "; echo "$newBalance <br><br>";

            //mysql query that allows the user to insert the values from the html form to the database fields using POST 
            $sqlMax =  "SELECT MAX(TransactionID) AS maxID FROM transaction";
            $result = mysqli_query($con,$sqlMax); //mysql query that selects the highest value from the customer ID from the customer, calling it maxid allows for it to be entered to the row array as an index and to get the result  
            $row = mysqli_fetch_assoc($result); //Fetches the result row as an associative array or as a numerical array
            $maxID = $row['maxID']; //Assigning the row with maxID as its index to the variable $maxID
            $maxID++; //Increments the maxID to represent the next ID which is to be auto-incremented

            $sqlUpdateTransaction = "INSERT INTO transaction (TransactionID,AccountID, AccountType, Type, Amount, Date, Balance)
            VALUES ('$maxID','$accountID', 'Current', 'Lodgement', '$lodgement', '$currentDate', '$newBalance')"; //Adding the lodgement information to the transactions table
            if (!mysqli_query($con, $sqlUpdateTransaction)) //Query is executed here
            {
                echo "Error ".mysqli_error($con); // Shows error if there is a problem with the MySQL statement or connection
            }        
        }
        else
        {
            echo "No records were changed"; //If the number of affected rows is zero, this message is shown
        }
    }
    }
    ?>

    <?php
    if($accountUsed == 'Deposit') //Lodgement made straight to the balance
    {
        $sqlDepositAccount = "SELECT Balance FROM account WHERE AccountID = '$accountID'"; //MySQL query to retrieve the accounts balance
        if (!$result = mysqli_query($con,$sqlDepositAccount)) //Query is executed here
        {
        die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
        }

        $depositAccountRow = mysqli_fetch_array($result); //Fetching the results of the query as an array
        $depositBalance = $depositAccountRow[0]; //Getting the balance from the result row 
        $newDepositBalance = $depositBalance + $lodgement; //Getting the new balance of the account by adding the old balance and lodgement made

        $sqlUpdateDepositAccount = "UPDATE account SET Balance = '$newDepositBalance' WHERE AccountID = '$accountID'"; //Updating the account details
        if (!mysqli_query($con, $sqlUpdateDepositAccount)) //Query is executed here
        {
            echo "Error ".mysqli_error($con); // Shows error if there is a problem with the MySQL statement or connection
        }
        else
        {
            if (mysqli_affected_rows($con) != 0) //Following code takes place if rows have been affected
        {
            $currentDateString = strtotime("today"); //Setting string to time to "today" will get the current date W3Schools
            $currentDate = date("Y-m-d", $currentDateString); //Formatting the date to "2000-12-12"

            echo "
            <h1>Lodgement Report</h1> <br><br> 
                    Date: "; echo $currentDate;
            echo    " &nbsp  &nbsp Customer Name: "; echo "$fname" . " " ."$lname <br><br>"; //Echoing html code to display the lodgement details
            echo    "Account Type: Deposit Account <br>";
            echo    "Lodgement Made: "; echo "$lodgement euro <br><br>";
            echo    "Previous Balance: "; echo "$depositBalance <br><br>";
            echo    "New Balance: "; echo "$newDepositBalance <br><br>";

            //mysql query that allows the user to insert the values from the html form to the database fields using POST 
            $sqlMax =  "SELECT MAX(TransactionID) AS maxID FROM transaction";
            $result = mysqli_query($con,$sqlMax); //mysql query that selects the highest value from the customer ID from the customer, calling it maxid allows for it to be entered to the row array as an index and to get the result  
            $row = mysqli_fetch_assoc($result); //Fetches the result row as an associative array or as a numerical array
            $maxID = $row['maxID']; //Assigning the row with maxID as its index to the variable $maxID
            $maxID++; //Increments the maxID to represent the next ID which is to be auto-incremented

            $sqlUpdateTransaction = "INSERT INTO transaction (TransactionID,AccountID, AccountType, Type, Amount, Date, Balance) 
            VALUES ('$maxID','$accountID', '$accountUsed', 'Lodgement', '$lodgement', '$currentDate', '$newDepositBalance')"; //Adding the lodgement information to the transactions table
            if (!mysqli_query($con, $sqlUpdateTransaction)) //Query is executed here
            {
                echo "Error ".mysqli_error($con); // Shows error if there is a problem with the MySQL statement or connection
            }        
        }
        else
        {
            echo "No records were changed"; //If the number of affected rows is zero, this message is shown
        }
    }
    }
    }
?>
    <form action = "CustomerLodgement.php" method = "POST" > <!--Submitting the form to the lodgement page despite sending no information will bring the user back to the lodgement screen -->
    <div class="returnToLodgement">
    <input type="submit" value="Return to lodgements" name="submit"/><br><br> <!-- Submit Button onclick="confirmChoices()" -->
	</div>
    </div>
    </form>