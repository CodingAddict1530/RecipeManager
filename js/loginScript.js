// Get the 'register' button by its ID
const registerBtn = document.getElementById("registerBtn");

// Set an event listener for the 'register' button click event
registerBtn.onclick = function () {
    // Redirect the user to the 'register.html' page
    window.location.href = "../html/register.html";
}

// Function to validate email and password inputs
function validate() {

    let validEmail = false; // Initialize email validation status as false
    let validPass = false; // Initialize password validation status as false

    // Get the email input field by its ID
    const email = document.getElementById("email");
    // Get the password input field by its ID
    let pass = document.getElementById("pass");

    // Validate the email using the checkEmail function
    if (checkEmail(email.value)) {
        validEmail = true; // Set email validation status to true if valid
    } else {
        // If email is invalid, add 'invalid' class to highlight the field
        email.classList.add("invalid");
        // Show the error message associated with the email field
        document.getElementById("hideEmail").classList.add("show");

        // Add an event listener to revalidate email on user input
        email.addEventListener("input", function() {
            if (checkEmail(email.value)) {
                // Remove invalid class and hide error message if email is valid
                email.classList.remove("invalid");
                document.getElementById("hideEmail").classList.remove("show");
            } else {
                // Keep the invalid class and show error message if still invalid
                email.classList.add("invalid");
                document.getElementById("hideEmail").classList.add("show");
            }
        })
    }

    // Validate the password using the checkPass function
    if (checkPass(pass.value)) {
        validPass = true; // Set password validation status to true if valid
    } else {
        // If password is invalid, add 'invalid' class to highlight the field
        pass.classList.add("invalid");
        // Show the error message associated with the password field
        document.getElementById("hidePass").classList.add("show");

        // Add an event listener to revalidate password on user input
        pass.addEventListener("input", function() {
            if (checkPass(pass.value)) {
                // Remove invalid class and hide error message if password is valid
                pass.classList.remove("invalid");
                document.getElementById("hidePass").classList.remove("show");
            } else {
                // Keep the invalid class and show error message if still invalid
                pass.classList.add("invalid");
                document.getElementById("hidePass").classList.add("show");
            }
        })
    }

    // Return true only if both email and password are valid
    return validEmail && validPass;
}

// Function to validate the email format using a regular expression
function checkEmail(email) {
    // Regular expression for validating email format
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email); // Return true if email matches the regex
}

// Function to validate the password length
function checkPass(pass) {
    // Return true if the password length is 8 characters or more
    return pass.length >= 8;
}
