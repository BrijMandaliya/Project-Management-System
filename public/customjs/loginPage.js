$(document).ready(function() {
    var signInBtn = $('#sign-in-btn');

    signInBtn.on("click", function() {
        var email = $('#InputEmail').val();
        var password = $('#InputPassword').val();

        console.log(isValidPassword(password));
        if (!(isValidEmail(email) && email.trim() != '')) {
            $('#errorEmail').removeClass('d-none');
            $('#errorEmail').html('Enter Valid Email');
        } else if (!(password.trim() == '' || isValidPassword(password))) {
            $('#errorPassword').removeClass('d-none');
            $('#errorPassword').html("Enter Valid Password");
        } else {
            $('#loginForm').submit();
        }

        setTimeout(function() {
            $('#errorEmail').addClass('d-none');
            $('#errorPassword').addClass('d-none');
        }, 2000);
    });
});
