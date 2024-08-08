// Wait for the entire DOM content to be loaded before executing the script
document.addEventListener('DOMContentLoaded', function() {

    // Filter text field functionality
    const filterInput = document.getElementById('filter'); // Get the filter input field by its ID
    const table = document.getElementById('recipes-table'); // Get the table by its ID
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr'); // Get all table rows within the tbody

    // Add an event listener to the filter input field to detect user input
    filterInput.addEventListener('input', function() {
        const filterValue = filterInput.value.toLowerCase(); // Get the lowercase value of the filter input

        // Loop through all rows in the table
        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td'); // Get all cells in the current row
            let rowText = '';

            // Concatenate the text content of all cells in the row
            for (let j = 0; j < cells.length; j++) {
                rowText += cells[j].textContent.toLowerCase();
            }

            // Check if the row text includes the filter value; show/hide the row accordingly
            if (rowText.includes(filterValue)) {
                rows[i].style.display = ''; // Show the row if it matches the filter
            } else {
                rows[i].style.display = 'none'; // Hide the row if it doesn't match
            }
        }
    });

    // Pagination functionality
    const entriesPerPageSelect = document.getElementById('entries-per-page'); // Get the entries-per-page select element
    const previousBtn = document.getElementById('previous-btn'); // Get the previous button by its ID
    const nextBtn = document.getElementById('next-btn'); // Get the next button by its ID
    const currentPageSpan = document.getElementById('current-page'); // Get the current page span element
    let currentPage = 1; // Initialize the current page to 1
    let entriesPerPage = parseInt(entriesPerPageSelect.value); // Get the initial entries per page value

    // Function to display a specific page of table rows
    function showPage(page) {
        const start = (page - 1) * entriesPerPage; // Calculate the starting index for the page
        const end = start + entriesPerPage; // Calculate the ending index for the page

        // Loop through all rows and show/hide them based on the current page
        Array.from(rows).forEach((row, index) => {
            row.style.display = index >= start && index < end ? '' : 'none';
        });

        currentPageSpan.textContent = page; // Update the current page display

        // Enable or disable the previous and next buttons based on the current page
        previousBtn.disabled = page === 1;
        nextBtn.disabled = end >= rows.length;
    }

    // Update the pagination when the entries per page value is changed
    entriesPerPageSelect.addEventListener('change', function() {
        entriesPerPage = parseInt(entriesPerPageSelect.value); // Update entries per page value
        showPage(1); // Show the first page after changing the entries per page
    });

    // Go to the previous page when the previous button is clicked
    previousBtn.addEventListener('click', function() {
        if (currentPage > 1) {
            showPage(--currentPage); // Decrement the current page and show it
        }
    });

    // Go to the next page when the next button is clicked
    nextBtn.addEventListener('click', function() {
        if ((currentPage * entriesPerPage) < rows.length) {
            showPage(++currentPage); // Increment the current page and show it
        }
    });

    showPage(currentPage); // Initially show the first page

    // Modal functionality
    const newRecipeBtn = document.getElementById("new-recipe"); // Get the "New Recipe" button by its ID
    const modal = document.getElementById("modal"); // Get the modal element by its ID
    const closeBtn = document.getElementById("closeBtn"); // Get the modal close button by its ID
    const saveBtn = document.getElementById("modal-save"); // Get the modal save button by its ID
    const logoutBtn = document.getElementById("logout"); // Get the logout button by its ID
    const modalForm = document.getElementById("modal-form"); // Get the modal form element by its ID

    // Show the modal when the "New Recipe" button is clicked
    newRecipeBtn.onclick = function () {
        modal.style.display = "block"; // Display the modal
    }

    // Close the modal when the close button is clicked
    closeBtn.onclick = function () {
        modal.style.display = "none"; // Hide the modal
    }

    // Handle the form submission when the save button is clicked
    saveBtn.onclick = function (event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(modalForm); // Create a FormData object from the form

        // Send the form data to the server using Fetch API
        fetch('save_recipe.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text()) // Parse the response as text
        .then(data => {
            if (data.includes('Recipe saved!')) {
                alert('Recipe Added Successfully'); // Show a success message
                modal.style.display = "none"; // Hide the modal
                location.reload(); // Reload the page to show the new recipe
            } else {
                alert('Error: ' + data); // Show an error message
            }
        })
        .catch(error => {
            console.error('Error:', error); // Log any errors to the console
        });
    }

    // Log the user out when the logout button is clicked
    logoutBtn.onclick = function () {
        window.location.href = "login.html"; // Redirect to the login page
    }

    // Close the modal if the user clicks outside of it
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none"; // Hide the modal if the user clicks outside of it
        }
    }
});
