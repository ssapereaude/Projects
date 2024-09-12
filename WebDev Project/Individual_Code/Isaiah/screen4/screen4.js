function listboxPopulate()
{
var sel = document.getElementById("customerListbox");
var ID;
var result;
result = sel.options[sel.selectedIndex].value; //.options sets or returns the value of the option using .selectedIndex to set or return the index
var customerDetails = result.split(', '); //Splits the string using a comma
document.getElementById("fnameID").value = customerDetails[0];
document.getElementById("lnameID").value = customerDetails[1]; //Assigning the html form inputs to an array
document.getElementById("addressID").value = customerDetails[2];
document.getElementById("custID").value = customerDetails[3];
document.getElementById("accID").value = customerDetails[4];
document.getElementById("balanceID").value = customerDetails[5];
document.getElementById("customerID").value = customerDetails[3];
}

function checkLodgement()
{
    if(document.getElementById("lodgementID") <= 0)
    {
        alert("Please ensure that the lodgement is greater than 0");
        event.preventDefault;
    }
    else
    {
        
    }
}

function confirmLodgement()
{
    var confirmation
    confirmation = confirm("Are you sure you want to lodge money into this account?"); //Confirmation text that pops up when details are about to be submitted
    if(confirmation)
    {   
        document.getElementById("fnameID").disabled = false;
        document.getElementById("lnameID").disabled = false;
        document.getElementById("custID").disabled = false;
        document.getElementById("accID").disabled = false;
        document.getElementById("accountUsedID").disabled = false;
        return true;
    }
    else
    {
        event.preventDefault(); //if confirmation is denied then the details will be prevented from being submitted
        return false;
    }
}

function chooseCurrent()
{
    document.getElementById("accountUsedID").value = "current";
    if(document.getElementById("accID").value == null)
    {
        document.getElementById("accID").value = document.getElementById("lodgeCurrentButton").value; 
    }
    else //Watching out for the case that the MySQL query already has the input box covered
    {
        document.getElementById("accID").value = null;
        document.getElementById("accID").value = document.getElementById("lodgeCurrentButton").value; 
    }
}

function chooseDeposit()
{
    document.getElementById("accountUsedID").value = "Deposit";
    if(document.getElementById("accID").value == null)
    {
        document.getElementById("accID").value = document.getElementById("lodgeDepositButton").value; 
    }
    else
    {
        document.getElementById("accID").value = null;
        document.getElementById("accID").value = document.getElementById("lodgeDepositButton").value; 
    }
}

function chooseLoan()
{
    document.getElementById("accountUsedID").value = "Loan";
    if(document.getElementById("accID").value == null)
    {
        document.getElementById("accID").value = document.getElementById("lodgeLoan").value; 
    }
    else
    {
        document.getElementById("accID").value = null;
        document.getElementById("accID").value = document.getElementById("lodgeLoanButton").value; 
    }
    
}


