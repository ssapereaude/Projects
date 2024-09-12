<!-- Name : Temur Rustamov
 Number : C00280204
 Description : Fetch Transactions  -->

<?php
    include("bankConnect.inc.php"); //connecting to db
    if(isset($_POST['accountid'])) // search by account id
    {
        $accountid = $_POST['accountid'];
    }
    $sql = "SELECT * FROM transaction WHERE AccountID = $accountid ORDER BY TransactionID DESC LIMIT 10";
	if(!$result = mysqli_query($con, $sql))
    	{
        	die('Oops...' . mysqli_error($con));
        }
		echo "
				<table>
				<tr>
					<th>Transaction ID </th>
					<th>Account ID </th>
					<th>Type </th>
					<th>Amount </th>
					<th>Date </th>";
while ($row = mysqli_fetch_array($result))

		{
			echo "
			<tr>
				<td>" . $row['TransactionID'] . "</td>
				<td>" . $row['AccountID'] . "</td>
				<td>" . $row['Type'] . "</td>
				<td>" . $row['Amount'] . "</td>
				<td>" . $row['Date'] . "</td>";
		}
	echo "</table></script>";
    mysqli_close($con);
