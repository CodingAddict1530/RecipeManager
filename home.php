<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

include 'db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT name, cuisine, dietary_preference, ingredients FROM recipes WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$recipes = [];
while ($row = $result->fetch_assoc()) {
    $recipes[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Recipe Manager</title>
    <!-- Other head elements -->
</head>
<body>
    <!-- Top-bar and main elements -->
    <div id="third-row">
        <table>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Cuisine</td>
                    <td>Dietary Preference</td>
                    <td>Ingredients</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recipes as $recipe): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($recipe['name']); ?></td>
                        <td><?php echo htmlspecialchars($recipe['cuisine']); ?></td>
                        <td><?php echo htmlspecialchars($recipe['dietary_preference']); ?></td>
                        <td><?php echo htmlspecialchars($recipe['ingredients']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Other rows and modal -->
</body>
</html>
