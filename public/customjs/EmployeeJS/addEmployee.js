$(document).ready(function () {


    $("#addEmployeeBtn").on("click", function () {
        let Emp_Full_Name = $("#EmployeeName").val();
        let Emp_Email = $("#EmployeeEmail").val();
        let Emp_Gender_Male = $("#MaleGender").is(":checked");
        let Emp_Gender_Female = $("#FemaleGender").is(":checked");
        let Emp_DOB = $("#employeeDOB").val();
        let Emp_Role = $("#EmployeeRole")[0].selectedIndex;
        let Emp_Phone_Number = $("#EmployeePhoneNumber").val();
        let Emp_Address = $("#EmployeeAddress").val();
        let Emp_Profile_Photo = $("#emp_profile_photo")[0].files.length;
        let Emp_Country = $("#EmployeeCountry")[0].selectedIndex;

        if (Emp_Full_Name.trim() == "") {
            $("#errorEmployeeFullName").html("Please Enter Employee Full Name");
            $("#EmployeeName").focus();
        } else if (Emp_Email.trim() == "") {
            $("#errorEmployeeEmail").html("Please Enter Employee Email ");
            $("#EmployeeEmail").focus();
        } else if (!isValidEmail(Emp_Email)) {
            $("#errorEmployeeEmail").html(
                "Please Enter Proper Employee Email "
            );
            $("#EmployeeEmail").focus();
        } else if (!(Emp_Gender_Male || Emp_Gender_Female)) {
            $("#errorEmployeeGender").html("Please Select Employee Gender");
            $("#MaleGender").focus();
        } else if (!Emp_DOB) {
            $("#errorEmployeeDOB").html("Please Select Employee Date Of Birth");
            $("#employeeDOB").focus();
        } else if (Emp_Role == 0) {
            $("#errorEmployeeRole").html("Please Select Employee Role");
            $("#EmployeeRole").focus();
        } else if (Emp_Phone_Number.trim() == "") {
            $("#errorEmployeePhoneNumber").html(
                "Please Enter Employee Phone Number"
            );
            $("#EmployeePhoneNumber").focus();
        } else if (Emp_Phone_Number.length != 10) {
            $("#errorEmployeePhoneNumber").html(
                "Please Enter 10 Digit Employee Phone Number"
            );
            $("#EmployeePhoneNumber").focus();
        } else if (Emp_Address.trim() == "") {
            $("#errorEmployeeAddress").html("Please Enter Employee Address");
            $("#EmployeeAddress").focus();
        } else if (Emp_Country == 0) {
            $("#errorEmployeeCountry").html("Please Select Employee Country");
            $("#EmployeeCountry").focus();
        } else {
            $("#addEmployeeForm").submit();
        }

        setTimeout(() => {
            $("#errorEmployeeFullName").html("");
            $("#errorEmployeeEmail").html("");
            $("#errorEmployeeEmail").html("");
            $("#errorEmployeeGender").html("");
            $("#errorEmployeeDOB").html("");
            $("#errorEmployeeRole").html("");
            $("#errorEmployeePhoneNumber").html("");
            $("#errorEmployeePhoneNumber").html("");
            $("#errorEmployeeAddress").html("");
            $("#errorEmployeeCountry").html("");
            $("#errorEmployeeProfilePhoto").html("");
        }, 3000);
    });
});
