//to populate data and store to the array

function populate()
{
    var sel = document.getElementById("listbox");
    var result;
    result = sel.options[sel.selectedIndex].value;
    var customerDetails = result.split(', ');
    document.getElementById("showID").value = customerDetails[0];
    document.getElementById("showFirstName").value = customerDetails[1];
    document.getElementById("showLastName").value = customerDetails[2];
    document.getElementById("showAddress").value = customerDetails[3];
    document.getElementById("showEircode").value = customerDetails[4];
    document.getElementById("showDOB").value = customerDetails[5];
    document.getElementById("showTelephone").value = customerDetails[6];
    document.getElementById("showAccountID").value = customerDetails[7];
    document.getElementById("showBalance").value = customerDetails[8];
}
// to disable the fields
function toggleLock()   
{
    document.getElementById("showID").disabled = false;
    document.getElementById("showFirstName").disabled = false;
    document.getElementById("showLastName").disabled = false;
    document.getElementById("showAccountID").disabled = false;
    document.getElementById("showBalance").disabled = false;
}
// to unable them 
function lock() 
{
    document.getElementById("showID").disabled = true;
    document.getElementById("showFirstName").disabled = true;
    document.getElementById("showLastName").disabled = true;
    document.getElementById("showAccountID").disabled = true;
    document.getElementById("showBalance").disabled = true;
}
// confirm popup and then testing
function confirmDelete()
{

    var response;

    response = confirm("Can you confirm?"); 
    if(response)
    {
        toggleLock();
        return true 
    }
    else 
    {
        return false
    }
}