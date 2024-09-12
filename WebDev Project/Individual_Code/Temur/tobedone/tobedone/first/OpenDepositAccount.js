
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
    document.getElementById("showDOB").value = customerDetails[4];
    document.getElementById("showTelephone").value = customerDetails[5];
}



//console.log(document.getElementById("showID").disabled)

function confirmCheck()
{
	
    var response;
    response = confirm("Can you confirm? "); 
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

function toggleLock()   
{
        document.getElementById("showID").disabled = false;
        document.getElementById("showFirstName").disabled = false;
        document.getElementById("showLastName").disabled = false;
}

function lock() 
{
    document.getElementById("showID").disabled = true;
    document.getElementById("showFirstName").disabled = true;
    document.getElementById("showLastName").disabled = true;
}

