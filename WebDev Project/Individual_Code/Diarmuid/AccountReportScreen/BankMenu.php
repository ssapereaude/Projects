<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="stylesheet" href="OIR BANK1.css">
        <title>OIR Banking System</title>
    </head>
    <body>
		<!--The start of the menu bar at the top-->
		<div class="navbar">
			<!--The list of items that make up the options on the top menu bar-->
			<ul class="nav-list" style="list-style-type: none">
				<li><a href="#">Lodgements</a></li>
				<li><a href="#">Withdrawals</a></li>
				<!--Dropdown menu for customers-->
				<li class="dropdown">
					<a href="#">Customers</a>
					<div class="dropdown-content">
						<a class="dropdownItem" href="#">Create</a><br>
						<a class="dropdownItem" href="#">View/Amend</a><br>
						<a class="dropdownItem" href="#">Delete</a>
					</div>
				</li>
				<!--Dropdown menu for all accounts, with nested dropdown menus-->
				<li class="dropdown">
					<a href="#">Accounts</a>
					<div class="dropdown-content">
						<!--The dropdown menu for loan accounts, nested within the accounts dropdown menu-->
						<div class="nestedLoan">
							<a class="dropdownItem" href="#">Loan Account</a>
							<div class="dropdown-content-loan">
								<a class="dropdownItem" href="#">Create</a><br>
								<a class="dropdownItem" href="#">View/Amend</a><br>
								<a class="dropdownItem" href="#">Delete</a>
							</div>
						</div><br>
						<!--The dropdown menu for current accounts, nested within the accounts dropdown menu-->
						<div class="nestedCurrent">
							<a class="dropdownItem" href="#">Current Account</a>
							<div class="dropdown-content-current">
								<a class="dropdownItem" href="#">Create</a><br>
								<a class="dropdownItem" href="#">View/Amend</a><br>
								<a class="dropdownItem" href="#">Delete</a>
							</div>
						</div><br>
						<!--The dropdown menu for deposit accounts, nested within the accounts dropdown menu-->
						<div class="nestedDeposit">
							<a class="dropdownItem" href="#">Deposit Account</a>
							<div class="dropdown-content-deposit">
								<a class="dropdownItem" href="#">Create</a><br>
								<a class="dropdownItem" href="#">View/Amend</a><br>
								<a class="dropdownItem" href="#">Delete</a>
							</div>
						</div>
					</div>
				</li>
				<!--Logo of the bank, which links back to the homepage-->
				<li><a href="OIR BANK.html"><img src="logo2.png" alt="Brand logo"></a></li>
				<li class="dropdown">
					<a href="#">Management Menu</a>
					<div class="dropdown-content">
						<!--NOTE: nestedCurrent is used here for the sake of reducing code redundancy. The name isn't fitting, but it works perfectly-->
						<div class="nestedCurrent">
							<a class="dropdownItem" href="#">Charge/Calculate Interest</a><br>
							<div class="dropdown-content-current">
								<a class="dropdownItem" href="#">Overdrawn Current Accounts</a><br>
								<a class="dropdownItem" href="#">View/Amend</a><br>
								<a class="dropdownItem" href="#">Delete</a>
							</div>
						</div>
						<a class="dropdownItem" href="#">Change Rates</a><br>
					</div>
				</li>
				<li><a href="#">Quotes</a></li>
				<li><a href="#">Reports</a></li>
				<li><a href="#">Change Password</a></li>
			</ul>
		</div>
    </body>
</html>