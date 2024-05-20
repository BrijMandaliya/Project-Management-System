$(document).ready(function () {
    $(".login-info-box").fadeOut();
    $(".login-show").addClass("show-log-panel");
});

$('.login-reg-panel input[type="radio"]').on("change", function () {
    if ($("#log-login-show").is(":checked")) {
        $(".register-info-box").fadeOut();
        $(".login-info-box").fadeIn();

        $(".white-panel").addClass("right-log");
        $(".register-show").addClass("show-log-panel");
        $(".login-show").removeClass("show-log-panel");
    } else if ($("#log-reg-show").is(":checked")) {
        $(".register-info-box").fadeIn();
        $(".login-info-box").fadeOut();

        $(".white-panel").removeClass("right-log");

        $(".login-show").addClass("show-log-panel");
        $(".register-show").removeClass("show-log-panel");
    }

});

$("#login-btn").on("click", function () {
    let Email = $("#floatingInputEmail").val();
    let Password = $("#floatingInputPassword").val();

    console.log(Password.length);
    if (Email.trim() == "") {
        $("#errorEmail").html("Enter Email");
    } else if (!isValidEmail(Email)) {
        $("#errorEmail").html("Enter Correct Email");
    } else if (Password.trim() == "") {
        $("#errorPassword").html("Enter Password");
    } else if (!isValidPassword(Password)) {
        $("#errorPassword").html("Password Length should be 8 to 32");
    } else {
        $("#login-form").submit();
    }

    setTimeout(() => {
        $("#errorEmail").html("");
        $("#errorPassword").html("");
    }, 3000);
});

$("#reset-password-btn").on("click", function () {
    let resetPasswordEmail = $("#floatingInputResetPaswordEmail").val();
    let resetPasswordCompanyName = $("#floatingResetPasswordCompanyName").val();

    if (resetPasswordEmail.trim() == "") {
        $("#errorResetPaswordEmail").html("Enter Email");
    } else if (!isValidEmail(resetPasswordEmail)) {
        $("#errorResetPaswordEmail").html("Enter Correct Email");
    } else if (resetPasswordCompanyName.trim() == "") {
        $("#errorCompanyName").html("Enter Company Name");
    }

    setTimeout(() => {
        $("#errorResetPaswordEmail").html("");
        $("#errorCompanyName").html("");
    }, 3000);
});

$("#Update-Password-btn").on("click",function(){
    let oldPassword = $("#OldPassword").val();
    let newPassword = $("#NewPassword").val();
    let confirmPassword = $("#ConfirmPassword").val();
    let employeeEmail = $("#employee_email").val();

    if(oldPassword.trim() == "")
    {
        $("#errorOldPassword").html("Enter Old Password");
    }
    else if(oldPassword != "12345678")
    {
        $("#errorOldPassword").html("old Password is Incorrect");
    }
    else if(newPassword.trim() == '')
    {
        $("#errorNewPassword").html("Enter New Password");
    }
    else if(!(isValidPassword(newPassword)))
    {
        $("#errorNewPassword").html("New Password length should be 8 to 32");
    }
    else if(confirmPassword.trim() == '')
    {
        $("#errorConfirmPassword").html("Enter Confirm Password");
    }
    else if(newPassword != confirmPassword)
    {
        $("#errorConfirmPassword").html("Confirm Password is not Match");
    }
    else
    {
        $.ajax({
            url:"/updateemployeepassword",
            type:"POST",
            data: {
                NewPassword : newPassword,
                EmployeeEmail : employeeEmail,
            },
            headers:{
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            success:function(response){
                if(response == 1)
                {
                    new Notify({
                        status: "success",
                        title: "Updated!",
                        text: "Password Updated SuccessFully",
                        effect: "fade",
                        speed: 300,
                        customClass: "",
                        customIcon: "",
                        showIcon: true,
                        showCloseButton: true,
                        autoclose: true,
                        autotimeout: 2000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: "outline",
                        position: "top right",
                        customWrapper: "",
                    });
                }
            },
            error:function(error){
                console.log(error);
            },
        })
    }

});

