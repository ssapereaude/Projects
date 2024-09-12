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
		<!--The main WELCOME message for the system, styled with the subjectbox class. Any mention of subjectboxes refers to the boxes found within the main body of the page underneath the menu bar-->
		<div class="subjectbox">
			
			<h1>Create a Current Account</h1>
            <?php
                include("bankConnect.inc.php");
				if ($_SESSION['currentCreated'] == 1)
					{
						echo "<form type='hidden' id='goBack' action='addCurrentAccount.html.php' method='post'>
							  </form>
							  <script>document.getElementById('goBack').submit();</script>";
					}
                $sql = "SELECT * FROM account WHERE DeletedFlag=0 AND CustomerID=$_POST[displayid] AND AccountType = 'current'";
                if (!$result = mysqli_query($con, $sql)) 
                {
                    die("ERROR CONNECTING TO DATABASE". mysqli_error($con));
                }
                else
                {
                    if ($row = mysqli_fetch_array($result))
                        {
                            echo"Customer already has a current account.";
                            echo"
                                <form action='addCurrentAccount.html.php' method='post'>
                                    <br>
                                    <button type='submit'>Return To Previous Page</button>
                                </form>";
                        }
                    else
                        {
                            $sql = "SELECT * FROM account ORDER BY AccountID DESC";
                            $result = mysqli_query($con, $sql);
                            if (mysqli_num_rows($result) == 0)
                                {
                                    $accountid = 1;
                                }
                            else
                                {
                                    $row = mysqli_fetch_array($result);
                                    $accountid = $row["AccountID"] + 1;  
                                }
                            
                            echo"
                            <p class='subjectboxtext'>
                                <form class='customerDetails' action='currentAccountAdded.html.php' method='post' onsubmit='return confirmDetails()'>
                                    <label for='displaycid'>Customer ID</label>
                                    <input value='$_POST[displayid]' tabindex='-1' type='number' name='displaycid' id='displaycid' disabled placeholder='Account ID'>
                                    <label for='displayid'>Account ID</label>
                                    <input value='$accountid' tabindex='-1' type='number' name='displayid' id='displayid' disabled placeholder='Account ID'>
                                    <label for='overdraft'>Overdraft Limit</label>
                                    <input type='number' step='0.01' name='overdraft' min='0.00' id='overdraft' required placeholder='XXXX.XX'>
                                    <label for='deposit'>Deposit (optional)</label>
                                    <input type='number' step='0.01' name='added' id='added' min='0.00' placeholder='Amount to be deposited'>
                                    <button style='margin-left:35%; margin-top: 20px; width: 200px;' type='submit'>Create Account</button>
                                </form>
                            </p>";
                        }
                }
			mysqli_close($con);
            ?>
            <script>
			if (document.getElementById('displayid').disabled == false)
				{
					toggleLock();
				}

            function confirmDetails()
			{
					status = confirm("Are you sure all details are correct?");
					if (status)
						{
							toggleLock();
						}
					return status;
            }
			function toggleLock()
			{
				if (document.getElementById('displayid').disabled)
				{
					document.getElementById('displayid').disabled = false;
					document.getElementById('displaycid').disabled = false;
				}
				else
				{
					document.getElementById('displayid').disabled = true;
					document.getElementById('displaycid').disabled = true;
				}
			}
            </script>
		</div>
    </body>
</html>