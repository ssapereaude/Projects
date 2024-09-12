<?php session_start(); ?>
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
		<!--The ACCOUNT ADDED message, styled with the subjectbox class. Any mention of subjectboxes refers to the boxes found within the main body of the page underneath the menu bar-->
        <div class="subjectbox">
			<h1>Withdraw Cash</h1>
            <p class="subjectboxtext">
                <?php
                    include ("bankConnect.inc.php");
                    $accountid = $_POST['displayaid'];
                    $balance = $_POST['displaybalance'];
                    $withdrawal = $_POST['withdraw'];
                    $name = $_POST['displayfname'] . " " . $_POST['displaysname']; 
                    $date = date_format(date_create(), "Y-m-d");
                    $newbalance = ($balance - $withdrawal);
                    if ($_SESSION['accountselected'] == "Current Accounts")
                        {
                            $accounttype = "Current";
                        }
                    else
                        {
                            $accounttype = "Deposit";
                        }
                    
                    if ($withdrawal == 0.00)
                        {
                            echo "Withdrawal of 0.00 entered. Balance of account id " . $accountid . " is unaffected.";
                        }
                    else
                        {
                            $sql = "UPDATE account SET Balance = '$newbalance' WHERE account.AccountID = '$accountid'";
                            if (!mysqli_query($con, $sql))
                                {
                                    echo mysqli_error($con);
                                }
                            else
                                {
                                    $sql = "SELECT TransactionID FROM transaction ORDER BY TransactionID DESC";
                                    $result = mysqli_query($con, $sql);
                                    if (mysqli_num_rows($result) == 0)
                                        {
                                            $transid = 1;
                                        }
                                    else
                                        {
                                            $row = mysqli_fetch_array($result);
                                            $transid = $row['TransactionID'] + 1;  
                                        }
                                    
                                    echo "Transaction Details:<br>
                                        Transaction ID:     $transid <br>
                                        AccountID:          $accountid <br>
                                        Old Balance:        $balance <br>
                                        Amount Withdrawn:   $withdrawal <br>
                                        New Balance:        $newbalance <br>
                                        Date:               $date <br>
                                            ";
                                    $sql = "INSERT INTO transaction (TransactionID, AccountID, AccountType, Type, Amount, Date, Balance) VALUES ('$transid', '$accountid', '$accounttype', 'Withdrawal', '$withdrawal', '$date', '$newbalance')";
                                    if(!mysqli_query($con, $sql))
                                        {
                                            echo mysqli_error($con);
                                        }
                                }
                        }
                    mysqli_close($con);
                ?>
            </p>
            <form action='OIR BANK.html.php' method='post'>
                <br>
                <button type='submit'>Return To Home Page</button>
            </form>
        </div>
        
    </body>
</html>