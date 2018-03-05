function validateForm() {
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;


    var a = document.forms["form"]["first_name"].value;
    var b = document.forms["form"]["last_name"].value;
    var c = document.forms["form"]["middle_name"].value;
    var d = document.forms["form"]["phone"].value;
    var e = document.forms["form"]["email"].value;
    var f = document.forms["form"]["region"].value;
    var g = document.forms["form"]["district"].value;
    var h = document.forms["form"]["affiliation"].value;
    var i = document.forms["form"]["time_worked"].value;
    var j = document.forms["form"]["select_time"].value;
    var k = document.forms["form"]["current_jod"].value;
    var l = document.forms["form"]["last_training_date"].value;
    var m = document.forms["form"]["type_of_training"].value;
    var n = document.forms["form"]["length_of_training"].value;
    var o = document.forms["form"]["training_organization"].value;
    var p = document.forms["form"]["training_certificate"].value;
    var q = document.forms["form"]["date_certificate_issued"].value;
    var r = document.forms["form"]["select_time2"].value;



    var elmt = document.getElementById("First name");
    var elmt2 = document.getElementById("Last name");
    var elmt3 = document.getElementById("Middle name");
    var elmt4 = document.getElementById("Phone number");
    var elmt5 = document.getElementById("Email");
    var elmt6 = document.getElementById("Region");
    var elmt7 = document.getElementById("District");
    var elmt8 = document.getElementById("Affiliation");
    var elmt9 = document.getElementById("Time worked as assesor/auditor");
    var elmt10 = document.getElementById("Time");

    var elmt11 = document.getElementById("Current job title");
    var elmt12 = document.getElementById("date");
    var elmt13 = document.getElementById("Type of activity/training");
    var elmt14 = document.getElementById("Length of activity/training");
    var elmt15 = document.getElementById("Training organization");
    var elmt16 = document.getElementById("Training certificate");
    var elmt17 = document.getElementById("date2");
    var elmt18 = document.getElementById("Comments");
    var elmt19 = document.getElementById("Time2");


    if (a == null || a == "")
    {
        elmt.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt.id + "''");
        return false;
    }
    if (b == null || b == "") {
        elmt2.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt2.id + "''");
        return false;
    }


    if (d == null || d == "") {
        elmt4.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt4.id + "''");
        return false;
    }


    if (e != "" && reg.test(e) == false)
    {
        elmt5.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert('Invalid Email Address for "' + elmt5.id + '"');
        return false;
    }

    if (f == null || f == "") {
        elmt6.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt6.id + "''");
        return false;
    }


    if (g == null || g == "") {
        elmt7.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt7.id + "''");
        return false;
    }


    if (h == null || h == "") {
        elmt8.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt8.id + "''");
        return false;
    }

    if (i == null || i == "") {
        elmt9.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt9.id + "''");
        return false;
    }

    if (j == null || j == "") {
        elmt10.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt10.id + "''");
        return false;
    }
    if (j == 'Days') {

        if (isNaN(i)) {
            elmt9.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
            alert("The number of days must be a number between 1 and 366.");
            return false;
        } else {
            if (i <= 0 || i > 366) {
                elmt9.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
                alert("The number of days must be between 1 and 366.");
                return false;
            }
        }
    }
    if (j == 'Weeks') {
        if (isNaN(i)) {
            elmt9.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
            alert("The number of weeks must be a number between 1 and 52.");
            return false;
        } else {
            if (i <= 0 || i > 52) {
                elmt9.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
                alert("The number of weeks must be between 1 and 52.");
                return false;
            }
        }
    }

    if (j == 'Months') {
        if (isNaN(i)) {
            elmt9.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
            alert("The number of months must be a number between 1 and 12.");
            return false;
        } else {
            if (i <= 0 || i > 12) {
                elmt9.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
                alert("The number of months must be between 1 and 12.");
                return false;
            }

        }
    }

    if (i == 'Years') {
        if (isNaN(i)) {
            elmt9.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
            alert("The number of Years must be a number.");
            return false;
        }
    }

    if (k == null || k == "") {
        elmt11.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt11.id + "''");
        return false;
    }


    if (l == null || l == "") {
        elmt12.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt12.id + "''");
        return false;
    }

    if (m == null || m == "") {
        elmt13.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt13.id + "''");
        return false;
    }

    if (n == null || n == "") {
        elmt14.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt14.id + "''");
        return false;
    }
    if (r == null || r == "") {
        elmt19.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter a 'Unit of time'");
        return false;
    }

    if (r == 'Days') {

        if (isNaN(n)) {
            elmt14.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
            alert("The number of days must be a number between 1 and 366.");
            return false;
        } else {
            if (n = 0 || n > 366) {
                elmt14.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
                alert("The number of days must be between 1 and 366.");
                return false;
            }
        }
    }
    if (r == 'Weeks') {
        if (isNaN(n)) {
            elmt14.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
            alert("The number of weeks must be a number between 1 and 52.");
            return false;
        } else {
            if (n <= 0 || n > 52) {
                elmt14.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
                alert("The number of weeks must be between 1 and 52.");
                return false;
            }
        }
    }

    if (r == 'Months') {
        if (isNaN(n)) {
            elmt14.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
            alert("The number of months must be a number between 1 and 12.");
            return false;
        } else {
            if (n <= 0 || n > 12) {
                elmt14.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
                alert("The number of months must be between 1 and 12.");
                return false;
            }

        }
    }

    if (r == 'Years') {
        if (isNaN(n)) {
            elmt14.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
            alert("The number of Years must be a number.");
            return false;
        }
    }

    if (o == null || o == "") {
        elmt15.style.boxShadow = "2px 2px 10px rgba(200, 0, 0, 0.85)";
        alert("Please enter the ''" + elmt15.id + "''");
        return false;
    }

    


}


function emptyInput(input) {

    input.style.boxShadow = 'none';
}

//function issued() {
//    var certificate = document.getElementById("Training certificate").value;
//    var date = document.getElementById("date_issued");
//
//    if (certificate == 'Yes') {
//        date.innerHTML = '<label>Date certificate issued (if available)</label><input type="text" id="date2" name="date_certificate_issued" autocomplete = "off", onclick="date_issued()" class="form-control">';
//        $("#date2").datepicker(
//                {
//                    showButtonPanel: true
//                    , dateFormat: 'dd-mm-yy'
//                    , dayNamesMin: ['Mon', 'Tues', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun']
//                    , dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', ' Thursday ', 'Friday', 'Saturday']
//                    , monthNamesShort: ['Jan', 'Fed', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
//                    , monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', ]
//                    , prevText: 'Previous'
//                    , nextText: 'Next',
//                    closeText: 'OK'
//                    , currentText: "Today"
//                });
//    }
//
//    if (certificate != 'Yes') {
//        date.innerHTML = '';
//    }
//}




$(document).ready(function () {

    $("#date").datepicker(
            {
                showButtonPanel: true
                , dateFormat: 'dd-mm-yy'
                , dayNamesMin: ['Mon', 'Tues', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun']
                , dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', ' Thursday ', 'Friday', 'Saturday']
                , monthNamesShort: ['Jan', 'Fed', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                , monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', ]
                , prevText: 'Previous'
                , nextText: 'Next'
                , closeText: 'OK'
                , currentText: "Today"
            });

}); //EOf:: DOM isReady


$(document).ready(function () {

    $("#date2").datepicker(
            {
                showButtonPanel: true
                , dateFormat: 'dd-mm-yy'
                , dayNamesMin: ['Mon', 'Tues', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun']
                , dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', ' Thursday ', 'Friday', 'Saturday']
                , monthNamesShort: ['Jan', 'Fed', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                , monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', ]
                , prevText: 'Previous'
                , nextText: 'Next'
                , closeText: 'OK'
                , currentText: "Today"
            });

}); //EOf:: DOM isReady






