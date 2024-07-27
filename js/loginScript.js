const registerBtn = document.getElementById("registerBtn")

registerBtn.onclick = function () {
    window.location.href = "register.html";
}

function validate() {

    let validEmail = false;
    let validPass = false;

    const email = document.getElementById("email");
    let pass = document.getElementById("pass");

    if (checkEmail(email.value)) {
        validEmail = true;
    } else {
        email.classList.add("invalid");
        document.getElementById("hideEmail").classList.add("show");
        email.addEventListener("input", function() {
            if (checkEmail(email.value)) {
                email.classList.remove("invalid");
                document.getElementById("hideEmail").classList.remove("show");
            } else {
                email.classList.add("invalid");
                document.getElementById("hideEmail").classList.add("show");
            }
        })
    }
    if (checkPass(pass.value)) {
        validPass = true;
    } else {
        pass.classList.add("invalid");
        document.getElementById("hidePass").classList.add("show");
        pass.addEventListener("input", function() {
            if (checkPass(pass.value)) {
                pass.classList.remove("invalid");
                document.getElementById("hidePass").classList.remove("show");
            } else {
                pass.classList.add("invalid");
                document.getElementById("hidePass").classList.add("show");
            }
        })
    }

    return validEmail && validPass;

}

function checkEmail(email) {

    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function checkPass(pass) {

    return pass.length >= 8;
}
