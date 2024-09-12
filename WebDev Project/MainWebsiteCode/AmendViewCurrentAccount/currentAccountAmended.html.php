<!--
	Stuart Rossiter
	c00284845
	April, 2024
	Current Account Amended
	Confirms whether the current account was amended
-->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="stylesheet" href="/MainWebsiteCode/MainStyling.css">
        <title>OIR Banking System</title>
    </head>
    <body>
		<?PHP include("/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/MainMenu.php");?>
		<!--The ACCOUNT AMENDED message, styled with the subjectbox class. Any mention of subjectboxes refers to the boxes found within the main body of the page underneath the menu bar-->
        <div class="subjectbox">
			<h1>Amend A Current Account</h1>
            <p class="subjectboxtext">
                <?php
					$_SESSION['amended'] = 1;
                    include ("/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/bankConnect.inc.php");
					//Update currentaccount with the new overdraft balance (it is the only amendable field)
                    $sql = "UPDATE currentaccount SET OverdraftLimit = $_POST[amendoverdraft] WHERE AccountID = $_POST[amendid]";
					//execute update
                    if (!mysqli_query($con, $sql))
                        {
                            echo mysqli_error($con);
                        }
                    else
                        {
                            if (mysqli_affected_rows($con) == 1) 
                                {
                                    echo "Account of ID " . $_POST['amendid'] . " has been updated.";
                                }
                            else
                                {
                                    echo "No changes were made to Account of ID " . $_POST['amendid'] . ".";
                                }
                        }
                ?>
            </p>
            <form action='/MainWebsiteCode/OIR BANK.html.php' method='post'>
                <br>
                <button type='submit'>Return To Home Page</button>
            </form>
        </div>
        
    </body>
</html>