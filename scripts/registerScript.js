// Get the 'login' button by its ID
const loginBtn = document.getElementById("loginBtn");

// Set an event listener for the 'login' button click event
loginBtn.onclick = function () {
    // Redirect the user to the 'login.html' page
    window.location.href = "../pages/login.html";
}

// Function to validate email, username, and password inputs
function validate() {

    let validEmail = false; // Initialize email validation status as false
    let validName = false; // Initialize username validation status as false
    let validPass = false; // Initialize password validation status as false
    let validPass2 = false; // Initialize password confirmation validation status as false

    // Get the email input field by its ID
    const email = document.getElementById("email");
    // Get the username input field by its ID
    const name = document.getElementById("login");
    // Get the password input field by its ID
    let pass = document.getElementById("pass");
    // Get the password confirmation input field by its ID
    const pass2 = document.getElementById("pass2");

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
        });
    }

    // Validate the username using the checkName function
    if (checkName(name.value)) {
        validName = true; // Set username validation status to true if valid
        // Convert the username to lowercase
        name.value = name.value.toLowerCase();
    } else {
        // If username is invalid, add 'invalid' class to highlight the field
        name.classList.add("invalid");
        // Show the error message associated with the username field
        document.getElementById("hideName").classList.add("show");

        // Add an event listener to revalidate username on user input
        name.addEventListener("input", function() {
            if (checkName(name.value)) {
                // Remove invalid class and hide error message if username is valid
                name.classList.remove("invalid");
                document.getElementById("hideName").classList.remove("show");
            } else {
                // Keep the invalid class and show error message if still invalid
                name.classList.add("invalid");
                document.getElementById("hideName").classList.add("show");
            }
        });
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
        });
    }

    // Validate the password confirmation using the checkPass2 function
    if (checkPass2(pass2.value, pass.value)) {
        validPass2 = true; // Set password confirmation validation status to true if valid
    } else {
        // If password confirmation is invalid, add 'invalid' class to highlight the field
        pass2.classList.add("invalid");
        // Show the error message associated with the password confirmation field
        document.getElementById("hidePass2").classList.add("show");

        // Add an event listener to revalidate password confirmation on user input
        pass2.addEventListener("input", function() {
            pass = document.getElementById("pass"); // Re-fetch the password field value
            if (checkPass2(pass2.value, pass.value)) {
                // Remove invalid class and hide error message if password confirmation is valid
                pass2.classList.remove("invalid");
                document.getElementById("hidePass2").classList.remove("show");
            } else {
                // Keep the invalid class and show error message if still invalid
                pass2.classList.add("invalid");
                document.getElementById("hidePass2").classList.add("show");
            }
        });
    }

    // Return true only if all validations (email, username, password, password confirmation) are successful
    return validEmail && validName && validPass && validPass2;
}

// Function to validate the email format using a regular expression
function checkEmail(email) {
    // Regular expression for validating email format
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email); // Return true if email matches the regex
}

// Function to validate the username length
function checkName(name) {
    // Return true if the username is not empty and has at most 30 characters
    return name.length > 0 && name.length <= 30;
}

// Function to validate the password length
function checkPass(pass) {
    // Return true if the password length is 8 characters or more
    return pass.length >= 8;
}

// Function to validate if the password confirmation matches the password
function checkPass2(pass2, pass) {
    // Return true if password confirmation matches the password and is not empty
    return pass2 === pass && pass2.length > 0;
}
