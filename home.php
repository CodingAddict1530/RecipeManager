<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

include 'db.php';

// Fetch recipes from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT name, cuisine, dietary_preference, ingredients FROM recipes WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if data is fetched
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
            background-color: rgb(0,0,0);
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
        <!-- Logout Form -->
        <form id="logout-form" method="post" action="logout.php" style="display: inline;">
            <button type="submit" id="logout">Logout</button>
        </form>
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
                    <select>
                        <option>1</option>
                        <option>5</option>
                        <option>10</option>
                    </select>
                    <span>entries</span>
                </div>
                <div>
                    <button class="previous-btn">Previous</button>
                    <button class="current" disabled>1</button>
                    <button class="next-btn">Next</button>
                </div>
            </div>
            <div id="third-row">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Cuisine</th>
                            <th>Dietary Preference</th>
                            <th>Ingredients</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recipes)): ?>
                            <?php foreach ($recipes as $recipe): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($recipe['name']); ?></td>
                                    <td><?php echo htmlspecialchars($recipe['cuisine']); ?></td>
                                    <td><?php echo htmlspecialchars($recipe['dietary_preference']); ?></td>
                                    <td><?php echo htmlspecialchars($recipe['ingredients']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No recipes found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div id="fourth-row">
                <span>Showing 1 to <?php echo count($recipes); ?> of <?php echo count($recipes); ?> recipes</span>
                <div>
                    <button class="previous-btn">Previous</button>
                    <button class="current" disabled>1</button>
                    <button class="next-btn">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Recipe Form -->
    <div id="new-recipe-form">
        <form action="add_recipe.php" method="post">
            <input type="text" name="recipe_name" placeholder="Recipe Name" required>
            <textarea name="recipe_details" placeholder="Recipe Details" required></textarea>
            <button type="submit">Add Recipe</button>
        </form>
    </div>

    <!-- Modal for adding new recipes -->
    <div id="modal">
        <div id="modal-content">
            <form id="modal-form" method="post" action="save_recipe.php">
                <div id="modal-head">
                    <span>New Recipe</span>
                    <span id="closeBtn">&times;</span>
                </div>
                <div id="new-recipe-name-container">
                    <label for="new-recipe-name">Name:</label>
                    <input id="new-recipe-name" name="name" type="text" required />
                </div>
                <div id="new-recipe-cuisine-container">
                    <label for="new-recipe-cuisine">Cuisine:</label>
                    <input id="new-recipe-cuisine" name="cuisine" type="text" required />
                </div>
                <div id="new-recipe-dp-container">
                    <label for="new-recipe-dp">Dietary Preference:</label>
                    <input id="new-recipe-dp" name="dietary_preference" type="text" required />
                </div>
                <div id="new-recipe-ingredients-container">
                    <label for="new-recipe-ingredients">Ingredients:</label>
                    <select id="new-recipe-ingredients" name="ingredients[]" multiple>
                        <option value="salt">Salt</option>
                        <option value="pepper">Pepper</option>
                        <option value="sugar">Sugar</option>
                        <option value="flour">Flour</option>
                    </select>
                </div>
                <div id="modal-foot">
                    <button type="submit">Save Recipe</button>
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

        // Show success message if recipe was added
        <?php if ($recipe_added): ?>
        alert('Recipe Added Successfully. Press the OK button to go back to homepage.');
        <?php endif; ?>
    </script>
</body>
</html>
