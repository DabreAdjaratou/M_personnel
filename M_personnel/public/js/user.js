function validateForm() {
    var a = document.forms["form"]["first_name"].value;
    var b = document.forms["form"]["last_name"].value;
    var c = document.forms["form"]["email"].value;
    var d = document.forms["form"]["login"].value;
    var e = document.forms["form"]["password"].value;
    var f = document.forms["form"]["confirm-password"].value;
    var g = document.forms["form"]["status"].value;
    var h = document.forms["form"]["role_id"].value;

    var elmt = document.getElementById("First name");
    var elmt2 = document.getElementById("Last name");
    var elmt3 = document.getElementById("Email");
    var elmt4 = document.getElementById("Login");
    var elmt5 = document.getElementById("Password");
    var elmt6 = document.getElementById("Confirm password");
    var elmt7 = document.getElementById("Status");
    var elmt8 = document.getElementById("Role");


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

    if (d == null || d == "")
    {
        elmt4.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt4.id + "''");
        return false;
    }
    if (e == null || e == "")
    {
        elmt5.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt5.id + "''");
        return false;
    } else if (e.length < 6) {
        elmt5.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("The input '" + elmt5.id + "' is less than 6 characters long");
        return false;
    }


    if (f == null || f == "")
    {
        elmt6.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt6.id + "''");
        return false;
    } else if (f.length < 6) {
        elmt6.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("The input '" + elmt6.id + "' is less than 6 characters long");
        return false;
    }


        if (g == null || g == "")
        {
            elmt7.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
            alert("Please enter the ''" + elmt7.id + "''");
            return false;
        }
        if (h == null || h == "")
        {
            elmt8.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
            alert("Please enter the ''" + elmt8.id + "''");
            return false;
        }


    }

    function emptyInput(input) {

        input.style.boxShadow = 'none';
    }


    