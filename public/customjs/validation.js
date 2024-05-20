// Function to validate email format
function isValidEmail(email) {
    // Regular expression for email validation
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPassword(password)
{
    if(password.length >= 8 && password.length <= 32)
    {
        return true
    }
    else
    {
        return false
    }
}
