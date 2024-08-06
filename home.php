<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

include 'db.php';

// Prepare and execute the query
$user_id = $_SESSION['user_id'];
$sql = "SELECT id, name, cuisine, dietary_preference, ingredients FROM recipes WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch recipes from the database
if ($result->num_rows > 0) {
    $recipes = [];
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
} else {
    $recipes = []; // Empty array if no recipes found
}

$stmt->close();
$conn->close();

// Check if the recipe was added successfully
$recipe_added = isset($_GET['success']) && $_GET['success'] == 1;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>Recipe Manager</title>
    <meta charset="UTF-8">
    <meta name="description" content="Recipe Manager">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="HTML, CSS, JavaScript, Portfolio">
    <meta name="author" content="Alexis Mugisha, Michael Nwaeze, Igwilo Chidumebi">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        /* Modal styling */
        #modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        #modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        #closeBtn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        #closeBtn:hover,
        #closeBtn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="top-bar">
        <h1>Recipe Manager</h1>
        <button id="logout">Logout</button>
    </div>
    <div id="main">
        <div id="top">
            <span>Recipes</span>
        </div>
        <div id="bottom">
            <div id="first-row">
                <button id="new-recipe">&plus; New Recipe</button>
                <div>
                    <label for="filter">Filter:</label>
                    <input id="filter" type="text" />
                </div>
            </div>
            <div id="second-row">
                <div>
                    <span>Show</span>
                    <select id="entries-per-page">
                        <option value="1">1</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                    </select>
                    <span>entries</span>
                </div>
                <div>
                    <button id="previous-btn" class="previous-btn">Previous</button>
                    <button id="current-page" class="current" disabled>1</button>
                    <button id="next-btn" class="next-btn">Next</button>
                </div>
            </div>
            <div id="third-row">
                <table id="recipes-table">
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Cuisine</td>
                            <td>Dietary Preference</td>
                            <td>Ingredients</td>
                            <td>Delete Recipe</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recipes as $recipe): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($recipe['name']); ?></td>
                            <td><?php echo htmlspecialchars($recipe['cuisine']); ?></td>
                            <td><?php echo htmlspecialchars($recipe['dietary_preference']); ?></td>
                            <td><?php echo htmlspecialchars($recipe['ingredients']); ?></td>
                            <td>
                                <form method="post" action="delete_recipe.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($recipe['id']); ?>">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div id="fourth-row">
                <span>Showing 1 to <?php echo count($recipes); ?> of <?php echo count($recipes); ?> recipes</span>
            </div>
        </div>
    </div>

    <div id="modal">
        <div id="modal-content">
            <form id="modal-form" method="post" action="save_recipe.php">
                <div id="modal-head">
                    <span>New Recipe</span>
                    <span id="closeBtn">&times;</span>
                </div>
                <div id="new-recipe-name-container">
                    <label for="new-recipe-name">Name:</label>
                    <input id="new-recipe-name" name="name" type="text" />
                </div>
                <div id="new-recipe-cuisine-container">
                    <label for="new-recipe-cuisine">Cuisine:</label>
                    <input id="new-recipe-cuisine" name="cuisine" type="text" />
                </div>
                <div id="new-recipe-dp-container">
                    <label for="new-recipe-dp">Dietary Preference:</label>
                    <input id="new-recipe-dp" name="dietary_preference" type="text" />
                </div>
                <div id="new-recipe-ingredients-container">
                    <label for="new-recipe-ingredients">Ingredients:</label>
                    <input id="new-recipe-ingredients" name="ingredients" type="text" placeholder="Enter ingredients separated by commas" style="width: 100%;" />
                </div>
                <div id="buttons-container">
                    <button id="modal-save" type="submit">Save</button>
                    <button id="modal-reset" type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Open modal
        document.getElementById('new-recipe').onclick = function() {
            document.getElementById('modal').style.display = 'block';
        };

        // Close modal
        document.getElementById('closeBtn').onclick = function() {
            document.getElementById('modal').style.display = 'none';
        };

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target == document.getElementById('modal')) {
                document.getElementById('modal').style.display = 'none';
            }
        };

        // Filter table rows
        document.getElementById('filter').addEventListener('input', function() {
            const filterValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#recipes-table tbody tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
                row.style.display = rowText.includes(filterValue) ? '' : 'none';
            });
        });

        // Pagination logic
        document.addEventListener('DOMContentLoaded', function() {
            const entriesPerPageSelect = document.getElementById('entries-per-page');
            const previousBtn = document.getElementById('previous-btn');
            const nextBtn = document.getElementById('next-btn');
            const currentPageSpan = document.getElementById('current-page');
            const table = document.getElementById('recipes-table');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
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
        });

        // Show success message if recipe was added
        <?php if ($recipe_added): ?>
        alert('Recipe Added Successfully. Press the OK button to go back to homepage.');
        <?php endif; ?>

        // Logout button functionality
        document.getElementById('logout').onclick = function() {
            window.location.href = 'logout.php'; // Redirect to logout script
        };
    </script>
</body>
</html>
