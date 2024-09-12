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
		<!--The AMEND ACCOUNT message, styled with the subjectbox class. Any mention of subjectboxes refers to the boxes found within the main body of the page underneath the menu bar-->
        <div class="subjectbox">
			<h1>Amend A Current Account</h1>
            <p class="subjectboxtext">
                <?php
                    include ("bankConnect.inc.php");
                    $sql = "UPDATE currentaccount SET OverdraftLimit = $_POST[amendoverdraft] WHERE AccountID = $_POST[amendid]";
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
            <form action='OIR BANK.html.php' method='post'>
                <br>
                <button type='submit'>Return To Home Page</button>
            </form>
        </div>
        
    </body>
</html>