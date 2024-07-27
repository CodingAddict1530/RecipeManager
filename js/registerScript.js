const loginBtn = document.getElementById("loginBtn")

loginBtn.onclick = function () {
    window.location.href = "login.html";
}

function validate() {

    let validEmail = false;
    let validName = false;
    let validPass = false;
    let validPass2 = false;

    const email = document.getElementById("email");
    const name = document.getElementById("login");
    let pass = document.getElementById("pass");
    const pass2 = document.getElementById("pass2");

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
    if (checkName(name.value)) {
        validName = true;
        name.value = name.value.toLowerCase();
    } else {
        name.classList.add("invalid");
        document.getElementById("hideName").classList.add("show");
        name.addEventListener("input", function() {
            if (checkName(name.value)) {
                name.classList.remove("invalid");
                document.getElementById("hideName").classList.remove("show");
            } else {
                name.classList.add("invalid");
                document.getElementById("hideName").classList.add("show");
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
    if (checkPass2(pass2.value, pass.value)) {
        validPass2 = true;
    } else {
        pass2.classList.add("invalid");
        document.getElementById("hidePass2").classList.add("show");
        pass2.addEventListener("input", function() {
            pass = document.getElementById("pass");
            if (checkPass2(pass2.value, pass.value)) {
                pass2.classList.remove("invalid");
                document.getElementById("hidePass2").classList.remove("show");
            } else {
                pass2.classList.add("invalid");
                document.getElementById("hidePass2").classList.add("show");
            }
        })
    }

    return validEmail && validName && validPass && validPass2;
    
}

function checkEmail(email) {

    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function checkName(name) {

    return name.length > 0 && name.length <= 30;
}

function checkPass(pass) {

    return pass.length >= 8;
}

function checkPass2(pass2, pass) {

    return pass2 === pass && pass2.length > 0;
}
