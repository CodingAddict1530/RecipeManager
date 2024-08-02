const newRecipeBtn = document.getElementById("new-recipe");
const modal = document.getElementById("modal");
const closeBtn = document.getElementById("closeBtn");
const saveBtn = document.getElementById("modal-save");
const logoutBtn = document.getElementById("logout");
const modalForm = document.getElementById("modal-form");

newRecipeBtn.onclick = function () {
    modal.style.display = "block";
}

closeBtn.onclick = function () {
    modal.style.display = "none";
}

saveBtn.onclick = function (event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(modalForm);

    fetch('save_recipe.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.includes('Recipe saved!')) {
            alert('Recipe Added Successfully');
            modal.style.display = "none";
            location.reload(); // Reload the page to show the new recipe
        } else {
            alert('Error: ' + data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

logoutBtn.onclick = function () {
    window.location.href = "login.html";
}

window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
