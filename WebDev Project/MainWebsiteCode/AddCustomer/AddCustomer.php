		<!--
		Name Of Screen: AddCustomer.php
		Purpose Of Screen: Form that allows for the user to enter customer details to be added to the database

		Student Name: Isaiah Andres
		Student Number: C00286361
		Date:25/02/2024 -->
		<!--Form submission box for the user to enter in the customer's details-->     
		<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="stylesheet" href="/MainWebsiteCode/MainStyling.css">
		<script type="text/javascript" src="AddCustomerFunctions.js" ></script>
        <title>Add A Customer</title>
    </head>
    <body>

		<?php include '/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/MainMenu.php'; ?>
		
        <div class="submissionBox">
        <fieldset class = "fieldsetCustomer">
        <form action="AddCustomerConfirm.php" method="post"> <!--Poating the information to AddCustomerConfirm.php -->
            <legend><h1>Customer Information Form</h1></legend>
            <br>
            <div class="fname">
            <label for="name">Customer First Name:</label> <!-- Input box for the first name-->
            <input type="text" name="fname" id="fnameID"  required autofocus/>
            </div>
            <br>
			<div class="lname">
			<label for="name">Customer Surname:</label> <!-- Input box for the last name-->
			<input type="text" name="lname" id="lnameID"  required autofocus/>
			</div>
			<br>
            <div class="address">
            <label for="address">Customer Address:</label>
            <input type="text" name="address" id="addressID" required autofocus />  <!-- input box for the address-->
            </div>
            <br>
            <div class="eircode">
            <label for="eircode">Customer Eircode:</label>
            <input type="text" name="eircode" id="eircodeID" required placeholder="A12 BC34" pattern="[A-Z0-9]{3} [A-Z0-9]{4}" autofocus/> <!--Text box for customer's eircode-->
            </div>
            <br>
            <div class="DOB">
            <label for="dateOfBirth">Date Of Birth:</label>
            <input type="date" name="dob" id="dobID" required autofocus oninput="checkAge()"/> <!--Using type date rather than numbers shows a calendar in which dates can be chosen from age rating?=18 -->
            </div>
            <br>
			<div class="phoneNo">
			<label for="phoneNo">Customer Phone Number:</label>
			<input type="tel" name="phoneNo" id="phoneNoID" placeholder="123 123 1234" pattern="[0-9\- \(\) +]{7,}" required autofocus/> <!-- input type tel allows a user to input a telephone number within the required pattern, pattern shou-->
			</div>
			<br>
			<div class="occupation">
			<label for="occupation">Customer Occupation:</label>
			<input type="text" name="occupation" id="occupationID" required autofocus/> <!-- input type tel allows a user to input a telephone number within the required pattern is the pattern our own choice?-->
			</div>
			<br>
            <div class="salary">
			<label for="salary">Customer Salary:</label>
			<input type="number" name="salary" id="salaryID" min="0" step=".01" autofocus/> <!--Using this rather than numbers shows a calendar in which dates can chosen from -->
			</div>
			<br>
			<div class="email">
			<label for="email">Customer Email:</label>
			<input type="email" name="email" id="emailID" required autofocus/> <!--Using this rather than numbers shows a calendar in which dates can chosen from -->
			</div>
			<br>
			<div class="guarantor">
			<label for="guarantor">Guarantor's Name:</label>
			<input type="text" name="gname" id="guarantorID" autofocus/> <!--Using this rather than numbers shows a calendar in which dates can chosen from -->
			</div>
			<br>
            <div class="myButton">
            <input type="submit" value="Send Form" name="submit" onclick="confirmChoices()"/><br><br> <!-- Submit Button-->
            <input type="reset" value="Clear Form" name="reset"/> <!-- Reset Button-->
			</div>
            </fieldset>
        </div>
    </form>

		</div>
    </body>
</html>