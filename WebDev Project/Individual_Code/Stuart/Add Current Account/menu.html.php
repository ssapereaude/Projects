<?php echo    '<!--The start of the menu bar at the top-->
		<div class="navbar">
			<!--The list of items that make up the options on the top menu bar-->
			<ul class="nav-list" style="list-style-type: none">
				<li><a href="#">Lodgements</a></li>
				<li><a href="withdrawCash.html.php">Withdrawals</a></li>
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
								<a class="dropdownItem" href="addCurrentAccount.html.php">Create</a><br>
								<a class="dropdownItem" href="amendViewCurrentAccount.html.php">View/Amend</a><br>
								<a class="dropdownItem" href="deleteCurrentAccount.html.php">Delete</a>
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
				<li><a href="OIR BANK.html.php"><img src="logo2.png" alt="Brand logo"></a></li>
				<li class="dropdown">
					<a href="#">Management Menu</a>
					<div class="dropdown-content">
						<!--NOTE: nestedCurrent and dropdown-content-current are used here for the sake of reducing code redundancy. The name isnt fitting, but it works perfectly-->
						<div class="nestedCurrent">
							<a class="dropdownItem" href="#">Charge/Calculate Interest</a><br>
							<div class="dropdown-content-current">
								<a class="dropdownItem" href="#">Overdrawn Current Accounts</a><br>
								<a class="dropdownItem" href="#">Deposit Accounts</a><br>
								<a class="dropdownItem" href="#">Current Accounts</a>
							</div>
						</div>
						<!--NOTE: nestedDeposit and dropdown-content-deposit areused here for the sake of reducing code redundancy. The name isnt fitting, but it works perfectly-->
						<div class="nestedDeposit">
							<a class="dropdownItem" href="#">Change Rates</a><br>
							<div class="dropdown-content-deposit">
								<a class="dropdownItem" href="#">Deposit Accounts</a><br>
								<a class="dropdownItem" href="#">Current Accounts</a><br>
								<a class="dropdownItem" href="#">Loan Accounts</a>
							</div>
						<div></div>
					</div>
				</li>
				<li><a href="#">Quotes</a></li>
				<li class="dropdown">
					<a href="#">Reports</a>
					<div class="dropdown-content">
						<!--NOTE: nestedCurrent and dropdown-content-current are used here for the sake of reducing code redundancy. The name isnt fitting, but it works perfectly-->
						<div class="nestedCurrent">
							<a class="dropdownItem" href="#">History</a><br>
							<div class="dropdown-content-current">
								<a class="dropdownItem" href="#">Deposit Account History</a><br>
								<a class="dropdownItem" href="#">Loan Account History</a><br>
								<a class="dropdownItem" href="#">Current Account History</a>
							</div>
						</div>
						<!--NOTE: nestedDeposit and dropdown-content-deposit areused here for the sake of reducing code redundancy. The name isnt fitting, but it works perfectly-->
						<div class="nestedDeposit">
							<a class="dropdownItem" href="#">Reports</a><br>
							<div class="dropdown-content-deposit">
								<a class="dropdownItem" href="#">Customer Report</a><br>
								<a class="dropdownItem" href="#">Current Account Interest Report</a><br>
								<a class="dropdownItem" href="#">Account Report</a>
							</div>
						<div></div>
					</div>
				</li>
				<li><a href="#">Change Password</a></li>
			</ul>
		</div>';