<?php session_start();?>
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
			<h1>Current Account Added</h1>
            <p class="subjectboxtext">
            Current Account has been added.
            </p>
            <form action='OIR BANK.html.php' method='post'>
                <br>
                <button type='submit'>Return To Home Page</button>
            </form>
        </div>
        <?php
			$_SESSION['currentCreated'] = 1;
            include ("bankConnect.inc.php");
            date_default_timezone_set('UTC');
			$date = date_create();
			$dateString = date_format($date, "Y-m-d");
            $balance = 0.00 + (float) $_POST['added'];
            $sql = "INSERT INTO account (AccountID, CustomerID, Balance, AccountType, Date, DeletedFlag) VALUES ($_POST[displayid], $_POST[displaycid], $balance, 'current', '$dateString', 0)";
            $result = mysqli_query($con, $sql);
            $sql = "SELECT * FROM rate WHERE type = 'current' ORDER BY RateID DESC";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            $sql = "INSERT INTO currentaccount VALUES ($_POST[displayid], $row[RateID], $_POST[overdraft])";
            $result = mysqli_query($con, $sql);
			if ($balance > 0.00)
			{ 
                $sql = "SELECT * FROM transaction ORDER BY TransactionID DESC";
                $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result) == 0)
                    {
                        $transactionID = 1;
                    }
                else
                    {
                        $row = mysqli_fetch_array($result);
                        $transactionID = $row['TransactionID'] + 1;
                    }
				$sql = "INSERT INTO transaction (TransactionID, AccountID, AccountType, Type, Amount, Date, Balance) VALUES ($transactionID, $_POST[displayid], 'Current', 'Initial Deposit', $balance, '$dateString', $balance)";
				$result = mysqli_query($con, $sql);
			}
			mysqli_close($con);
        ?>
    </body>
</html>