$(document).ready(function() {
    var signUpBtn = $('#sign-up-btn');
    var regitserForm = $('#registerForm');

    signUpBtn.on("click", function() {
        var Name = $('#InputName').val();
        var userName = $('#InputUserName').val();
        var email = $('#InputEmail').val();
        var companyName = $('#InputCompanyName').val();
        var country = $('#SelectCountry').val();
        var password = $('#InputPassword').val();

        if (!(Name.trim() != '')) {
            $('#errorName').removeClass('d-none');
            $('#errorName').html('Please Enter Name');
        } else if (!(userName.trim() != '')) {
            $('#errorUserName').removeClass('d-none');
            $('#errorUserName').html('Please Enter User Name');
        } else if (userName == Name) {
            $('#errorUserName').removeClass('d-none');
            $('#errorUserName').html('Name and Username are not same');
        } else if (!(isValidEmail(email) && email.trim() != '')) {
            $('#errorEmail').removeClass('d-none');
            $('#errorEmail').html('Enter Valid Email');
        } else if (!(companyName.trim() != '')) {
            $('#errorCompanyName').removeClass('d-none');
            $('#errorCompanyName').html('Please Enter Company Name');
        } else if (country == 'Country') {
            $('#errorCountry').removeClass('d-none');
            $('#errorCountry').html("Please Select Country");
        } else if (!(password.trim() != '' || isValidPassword(password))) {
            $('#errorPassword').removeClass('d-none');
            $('#errorPassword').html("Enter Valid Password");
        } else {
            regitserForm.submit();
        }

        setTimeout(function() {
            $('#errorUserName').addClass('d-none');
            $('#errorCompanyName').addClass('d-none');
            $('#errorEmail').addClass('d-none');
            $('#errorCountry').addClass('d-none');
            $('#errorPassword').addClass('d-none');
        }, 2000);
    });
});
