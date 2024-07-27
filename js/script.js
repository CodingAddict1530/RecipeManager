const newRecipeBtn = document.getElementById("new-recipe");
const modal = document.getElementById("modal");
const closeBtn = document.getElementById("closeBtn");
const saveBtn = document.getElementById("modal-save");
const logoutBtn = document.getElementById("logout");

newRecipeBtn.onclick = function () {
    modal.style.display = "block";
}

closeBtn.onclick = function () {
    modal.style.display = "none";
}

saveBtn.onclick = function () {
    modal.style.display = "none";
}

logoutBtn.onclick = function () {
    window.location.href = "login.html";
}

window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
