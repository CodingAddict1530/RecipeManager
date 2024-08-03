document.addEventListener('DOMContentLoaded', function() {
    // Filter text field functionality
    const filterInput = document.getElementById('filter');
    const table = document.getElementById('recipes-table');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    filterInput.addEventListener('input', function() {
        const filterValue = filterInput.value.toLowerCase();

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let rowText = '';

            for (let j = 0; j < cells.length; j++) {
                rowText += cells[j].textContent.toLowerCase();
            }

            if (rowText.includes(filterValue)) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    });

    // Pagination functionality
    const entriesPerPageSelect = document.getElementById('entries-per-page');
    const previousBtn = document.getElementById('previous-btn');
    const nextBtn = document.getElementById('next-btn');
    const currentPageSpan = document.getElementById('current-page');
    let currentPage = 1;
    let entriesPerPage = parseInt(entriesPerPageSelect.value);

    function showPage(page) {
        const start = (page - 1) * entriesPerPage;
        const end = start + entriesPerPage;

        Array.from(rows).forEach((row, index) => {
            row.style.display = index >= start && index < end ? '' : 'none';
        });

        currentPageSpan.textContent = page;

        previousBtn.disabled = page === 1;
        nextBtn.disabled = end >= rows.length;
    }

    entriesPerPageSelect.addEventListener('change', function() {
        entriesPerPage = parseInt(entriesPerPageSelect.value);
        showPage(1);
    });

    previousBtn.addEventListener('click', function() {
        if (currentPage > 1) {
            showPage(--currentPage);
        }
    });

    nextBtn.addEventListener('click', function() {
        if ((currentPage * entriesPerPage) < rows.length) {
            showPage(++currentPage);
        }
    });

    showPage(currentPage);

    // Modal functionality
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
});
