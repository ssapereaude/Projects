<!-- Name : Temur Rustamov
 Number : C00280204
 Description : View Deposit Account  -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="stylesheet" href="./OIR BANK.css">
        <title>OIR Banking System</title>
    </head>
    <body>
		<?php
		include("/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/MainMenu.php");
		?>

<!-- php part -->
		<div class="subjectbox">
            <h1> View Deposit Account</h1>
			<?php
			include "/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/bankConnect.inc.php";

				date_default_timezone_set("GMT");
				
                $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, depositaccount.AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE account.DeletedFlag=0 AND account.AccountType='deposit'"; //sql statement to get data

                if(!$result = mysqli_query($con, $sql))
                    {
                        die('Error...' . mysqli_error($con));
                    }
                echo"<br><div style='display: flex;'><select name='listbox' id='listbox' onclick='populate()'>"; // to populate with data 
                while($row = mysqli_fetch_array($result))
                    {
					//assinging data from db to the delcared variables
                        $customerid = $row['CustomerID'];
                        $firstname = $row['FirstName'];
                        $surname = $row['LastName'];
                        $address = $row['Address'];
                        $eircode = $row['Eircode'];
                        $dateOfBirth = $row['DOB'];
                        $telephone = $row['Telephone'];
                        $accountid = $row['AccountID'];
                        $balance = $row['Balance'];
                        $amount=$row['AmountRequested'];
                        $alltext = "$customerid,$firstname,$surname,$address,$eircode,$dateOfBirth,$telephone,$accountid,$balance,$amount";
                        echo"<option value = '$alltext'>$firstname $surname</option>";
                    }
                echo "</select>";
                mysqli_close($con);
            ?>
            <script>
                function populate()
                {
                    var sel = document.getElementById("listbox");
                    var result;
                    result = sel.options[sel.selectedIndex].value; //getting values
                    var personDetails = result.split(','); //split it by comma
					//putting everything into an array
					document.getElementById("cid").value = personDetails[0];
                    document.getElementById("fname").value = personDetails[1];
                    document.getElementById("sname").value = personDetails[2];
					document.getElementById("address").value = personDetails[3];
					document.getElementById("eircode").value = personDetails[4];
                    document.getElementById("dob").value = personDetails[5];
					document.getElementById("telephone").value = personDetails[6];
					document.getElementById("id").value = personDetails[7];
					document.getElementById("balance").value = personDetails[8];
					document.getElementById("amount").value = personDetails[9];
					//for displaying previous transactions
					var AJAX = new XMLHttpRequest();
					AJAX.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200)
							{
								document.getElementById("history").innerHTML = this.responseText;
							}
					};
					AJAX.open("POST", "ft.php");
					var postID = "accountid=" + encodeURIComponent(personDetails[7]);
					AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					AJAX.send(postID);
                }

                function toggleLock()
                {
                    document.getElementById("showCID").disabled = true;
                            document.getElementById("amendcid").disabled = true;
                            document.getElementById("amendfname").disabled = true;
                            document.getElementById("amendsname").disabled = true;
                            document.getElementById("amendaddress").disabled = true;
                            document.getElementById("amendeircode").disabled = true;
                            document.getElementById("amenddob").disabled = true;
                            document.getElementById("amendtelephone").disabled = true;
                            document.getElementById("amendbalance").disabled = true;
                            document.getElementById("amendamount").disabled = true;
                }

                function confirmDetails()
                {
                    var response;
                    response = confirm('Are you sure you want to save these changes?'); 
                    if (response) //if true
                    {
                        //enable
                        document.getElementById("amendid").disabled = false;
                        document.getElementById("amendfname").disabled = false;
                        document.getElementById("amendsname").disabled = false;
                        document.getElementById("amendamount").disabled = false;
                        return true;
                    }
                    else //otherwise populate 
                    {
                        populate();
                        toggleLock();
                        return false;
                    }
                }
				
            </script>
			<!-- buttons to search by -->
			<form action="vda.php" onsubmit="return mySearch(0, 'search')" method="POST">
			          <input style="width: 100px; margin-left:30px;" type="text" id="search" name="search" placeholder="CustomerID" >  
        <button type="submit">Search</button>    

    </form>    
    
    <form action="vda.php" onsubmit="return mySearch(7, 'searchAccount')" method="POST"> 
        <input style="width: 100px; margin-left:30px;" type="text" id="searchAccount" name="searchAccount" placeholder="AccountID" >  
        <button type="submit">Search</button>    
    </form>
			
	  </div>
	  <br>
<!-- js for searching by account id or customer id-->
    <script>
      function mySearch(criteriaIndex, inputId){
        const val = document.getElementById(inputId).value
        const listbox = document.getElementById("listbox")
		const options = listbox.children
		
		let i = 0;
		let selectedIndex = -1
		
		while(i < options.length){
			if(options[i].value.split(",")[criteriaIndex]==val){
				selectedIndex = i
			}
			
			i++
		}
		  
		 if(selectedIndex != -1){
		 	listbox.selectedIndex = selectedIndex
			 populate()
		 }
		  else {
			container = document.getElementById('details');
			inputs = container.getElementsByTagName('input');
			  
			i = 0
			 while(i < inputs.length){
			 
				 inputs[i].value = ""
				 
				 i++
			 }
			  
			  document.getElementById("history").innerHTML = ""
			  
		  }
		  
		  document.getElementById(inputId).value = ""

        return false
      }
    </script>
    <?php
			include "bankConnect.inc.php";
                session_start();



    $accountID=null;   // initialization to null
 if(isset($_POST['searchAccount'])) 
    {
        $accountID=$_POST['searchAccount'];
		echo $accountID;



       
        $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE customer.DeletedFlag=0 AND account.AccountType='Deposit' AND account.DeletedFlag=0 ";//sql statement to get data 
 
        if (!$result=mysqli_query($con, $sql))
        {
            die( 'Error in querying the database'.mysqli_error($con)); //testing
        }

        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);

            // fetching 

            $customerid = $row['CustomerID'];
					$accountid = $row['AccountID'];
                        $firstname = $row['FirstName'];
                        $surname = $row['LastName'];
                        $address = $row['Address'];
                        $eircode = $row['Eircode'];
                        $dateOfBirth = $row['DOB'];
                        $telephone = $row['Telephone'];
                        $balance = $row['Balance'];
                        $Amount = $row['AmountRequested'];

        }

        else 
        {

            $firstname = $accountid= $surname = $address = $eircode = $dateOfBirth = $telephone = $balance = $Amount = "";// otherwise assing to empty value
        }
    }
			mysqli_close($con);
?>

<?php
			include "bankConnect.inc.php";
                session_start();


    $customerID=null;   // initialization the cid to null
	  
    if(isset($_POST['search'])) 
    {
        $customerID=$_POST['search'];


        $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE customer.DeletedFlag=0 AND account.AccountType='Deposit' AND account.DeletedFlag=0 "; //sql statement to get data 

        if (!$result=mysqli_query($con, $sql))
        {
            die( 'Error in querying the database'.mysqli_error($con)); //testing
        }

        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);

            //fetching

            $customerid = $row['CustomerID'];
					$accountid = $row['AccountID'];
                        $firstname = $row['FirstName'];
                        $surname = $row['LastName'];
                        $address = $row['Address'];
                        $eircode = $row['Eircode'];
                        $dateOfBirth = $row['DOB'];
                        $telephone = $row['Telephone'];
                        $balance = $row['Balance'];
                        $Amount = $row['AmountRequested'];

        }

        else 
        {

            $firstname = $accountid= $surname = $address = $eircode = $dateOfBirth = $telephone = $balance = $Amount = ""; //otherwise assign to empty value
        }
    }
			mysqli_close($con);
?>
			

          <form id="display" class="inputbox">
                <label for="id">Your Account ID</label>
                <input type="text" name="id" id="id"  disabled placeholder="Account ID">
			<br><br>
                <label for="cid">Your Customer ID</label>
                <input type="text" name="cid" id="cid" disabled placeholder="Customer ID">
				<br><br>
                <label for="fname">Your First Name</label>
                <input type="text" name="fname" id="fname" disabled placeholder="First Name">
				<br><br>
                <label for="sname">Your Surname</label>
                <input type="text" name="sname" id="sname" disabled placeholder="Surname">
				<br><br>
                <label for="address">Your Address</label>
                <input type="text" name="address" id="address" disabled placeholder="Address">
				<br><br>
                <label for="eircode">Your Eircode</label>
                <input type="text" name="eircode" id="eircode" disabled placeholder="Eircode">
				<br><br>
                <label for="dob">Your Date of Birth</label>
                <input type="date" name="dob" id="dob" disabled placeholder="Date of Birth">
				<br><br>
                <label for="telephone">Your Telephone</label>
                <input type="text" name="telephone" id="telephone" disabled placeholder="Telephone">
				<br><br>
				<label for="balance">Your Expected Balance</label>
                <input type="text" name="balance" id="balance" disabled placeholder="Balance">
				<br><br>
				<label for="amount">Your Amount</label>
                <input type="text" name="amount" id="amount" disabled placeholder="Amount">
                <br><br>
            </form>
		</div>
		<div class="subjectbox">
            <h1>Previous Transactions</h1>
			<div id="history">
			
		</div>
		</div>
    </body>
</html>