<!-- Name : Temur Rustamov
 Number : C00280204
 Description : Deposit Account History  -->
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
            <h1> Deposit Account History</h1>
			<?php
                include "bankConnect.inc.php"; //connecting to db


				date_default_timezone_set("GMT");
				
                $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName,account.AccountID, account.Balance, depositaccount.AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE account.DeletedFlag=0 AND account.AccountType='deposit'"; //sql statement

                if(!$result = mysqli_query($con, $sql))
                    {
                        die('Oops...' . mysqli_error($con));
                    }
                echo"<br><div style='display: flex;'><select name='listbox' id='listbox' onclick='populate()'>";
                while($row = mysqli_fetch_array($result))
                    {
                        $customerid = $row['CustomerID'];
                        $firstname = $row['FirstName'];
                        $surname = $row['LastName'];
                       
                        $accountid = $row['AccountID'];
                        $balance = $row['Balance'];
                        $amount=$row['AmountRequested'];
                        $alltext = "$customerid,$firstname,$surname,$accountid,$balance,$amount";
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
                    result = sel.options[sel.selectedIndex].value; //values from listbox
                    var personDetails = result.split(','); //splitting 
//updating values
					document.getElementById("cid").value = personDetails[0];
                    document.getElementById("fname").value = personDetails[1];
                    document.getElementById("sname").value = personDetails[2];
				
					document.getElementById("id").value = personDetails[3];
					document.getElementById("balance").value = personDetails[4];
					document.getElementById("amount").value = personDetails[5];
					//AJAX, or Asynchronous Javascript And XML
					var AJAX = new XMLHttpRequest();
					AJAX.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200)
							{
								document.getElementById("history").innerHTML = this.responseText;
							}
					};
					AJAX.open("POST", "ft.php");
					var postID = "accountid=" + encodeURIComponent(personDetails[3]);
					AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					AJAX.send(postID);
                }

                function toggleLock()
                {
                            document.getElementById("cid").disabled = true;
                            document.getElementById("fname").disabled = true;
                            document.getElementById("sname").disabled = true;
                            document.getElementById("balance").disabled = true;
                            document.getElementById("amount").disabled = true;
                }

                function confirmDetails()
                {
                    var response;
                    response = confirm('Are you sure you want to save these changes?'); //Ask if user wants to save changes
                    if (response) //if true
                    {
                        //enable all of them
                        document.getElementById("id").disabled = false;
                        document.getElementById("fname").disabled = false;
                        document.getElementById("sname").disabled = false;
                        document.getElementById("amount").disabled = false;
                        return true;
                    }
                    else //otherwise
                    {
                        //repopulate to undo any changes
                        populate();
                        //relock the fields
                        toggleLock();
                        return false;
                    }
                }
				
            </script>
			<!-- searching either by account/customer id-->
			<form action="dh.php" onsubmit="return mySearch(0, 'search')" method="POST">
			          <input style="width: 100px; margin-left:30px;" type="text" id="search" name="search" placeholder="CustomerID" >  
        <button type="submit">Search</button>    

    </form>    
    
    <form action="dh.php" onsubmit="return mySearch(3, 'searchAccount')" method="POST"> 
        <input style="width: 100px; margin-left:30px;" type="text" id="searchAccount" name="searchAccount" placeholder="AccountID" >  
        <button type="submit">Search</button>  
    </form>
			
	  </div>
	  <br>

    <script>
		//js to search by account id/customer id
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
			include "bankConnect.inc.php"; //connecting to db
                session_start();



    $accountID=null;   // first of all initialized to null 
 if(isset($_POST['searchAccount'])) 
    {
        $accountID=$_POST['searchAccount'];


       
        $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName,account.AccountID, account.Balance, AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE customer.DeletedFlag=0 AND account.AccountType='Deposit' AND account.DeletedFlag=0 "; //sql statement to get values

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
                        
                        $balance = $row['Balance'];
                        $Amount = $row['AmountRequested'];

        }

        else 
        {

            $firstname = $accountid= $surname = $balance = $Amount = ""; //otherwise set to empty values
        }
    }
			mysqli_close($con);
?>

<?php
			include "bankConnect.inc.php"; //connecting to db
                session_start();



    $customerID=null;   // first of all initialized to empty value
	  
    if(isset($_POST['search'])) 
    {
        $customerID=$_POST['search'];



        $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName,account.AccountID, account.Balance, AmountRequested FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID WHERE customer.DeletedFlag=0 AND account.AccountType='Deposit' AND account.DeletedFlag=0 "; //sql statement

        if (!$result=mysqli_query($con, $sql))
        {
            die( 'Error in querying the database'.mysqli_error($con)); //testing
        }

        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);


              $customerid = $row['CustomerID'];
					$accountid = $row['AccountID'];
                        $firstname = $row['FirstName'];
                        $surname = $row['LastName'];
                        
                        $balance = $row['Balance'];
                        $Amount = $row['AmountRequested'];

        }

        else 
        {

            $firstname = $accountid= $surname = $balance = $Amount = ""; //set to empty value
        }
    }
			mysqli_close($con);
?>
			

          <form id="display" class="inputbox">
                <label for="id">Your Account ID</label>
                <input type="text" name="id" id="id"  disabled placeholder="Your Account ID">
			<br><br>
                <label for="cid">Your Customer ID</label>
                <input type="text" name="cid" id="cid" disabled placeholder="Your Customer ID">
				<br><br>
                <label for="fname">Your First Name</label>
                <input type="text" name="fname" id="fname" disabled placeholder="Your First Name">
				<br><br>
                <label for="sname">Your Surname</label>
                <input type="text" name="sname" id="sname" disabled placeholder="Your Surname">
				<br><br>
				<label for="balance">Your Expected Balance</label>
                <input type="text" name="balance" id="balance" disabled placeholder="Your Expected Balance">
				<br><br>
				<label for="amount">Your Amount</label>
                <input type="text" name="amount" id="amount" disabled placeholder="The Last Requested Amount was">
                <br><br>
                <button type="submit">Print Statement</button>
            </form>

		</div>
		<div class="subjectbox">
			<h1>Deposit Account History</h1>
			<div id="history">
			
		</div>
		</div>
    </body>
</html>