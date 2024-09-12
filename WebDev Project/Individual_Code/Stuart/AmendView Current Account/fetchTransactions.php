<?php
    include("bankConnect.inc.php");
    if(ISSET($_POST['accountid']))
    {
        $accountid = $_POST['accountid'];
    }
    $sql = "SELECT * FROM transaction WHERE AccountID = $accountid ORDER BY TransactionID DESC";
	if(!$result = mysqli_query($con, $sql))
    	{
        	die('ERROR IN QUERYING THE DATABASE' . mysqli_error($con));
        }
		$counter = 0;
		echo "
				<table>
				<tr>
					<th>Transaction ID</th>
					<th>Account ID</th>
					<th>Type</th>
					<th>Amount</th>
					<th>Date</th>";
		while ($row = mysqli_fetch_array($result) and $counter < 10)
		{
			echo "
			<tr>
				<td>" . $row['TransactionID'] . "</td>
				<td>" . $row['AccountID'] . "</td>
				<td>" . $row['Type'] . "</td>
				<td>" . $row['Amount'] . "</td>
				<td>" . $row['Date'] . "</td>";
			$counter++;
		}
	echo "</table></script>";
    mysqli_close($con);
