function validateForm() {
var a = document.forms["form"]["code"].value;
var b = document.forms["form"]["name"].value;
var c = document.forms["form"]["status"].value;

var elmt = document.getElementById("Role code");
var elmt2 = document.getElementById("Role name");
var elmt3 = document.getElementById("Status");

if (a == null || a == "")
    {
        elmt.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt.id + "''");
        return false;
    }
    
    if (b == null || b == "")
    {
        elmt2.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt2.id + "''");
        return false;
    }
    
   
if (c == null || c == "")
    {
        elmt3.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt3.id + "''");
        return false;
    }
    
}

function emptyInput(input) {

    input.style.boxShadow = 'none';
}

