<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Details</title>
    <link rel="stylesheet" href="view_recipe_details.css">
</head>
<body>
<?php
// Check if recipe ID is provided in the query string
if (isset($_GET['id'])) {
    // Get the recipe ID from the query string
    $recipe_id = $_GET['id'];

    // Connect to your database (replace with your database connection code)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "recipe_details";

    // Create connection
    $connection = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Prepare and execute a query to fetch recipe details based on the recipe ID
    $query = "SELECT * FROM rd_table WHERE recipeid = $recipe_id";
    $result = mysqli_query($connection, $query);

    // Check if query executed successfully and if there is at least one row returned
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the recipe details from the result
        $row = mysqli_fetch_assoc($result);

        // Display the recipe details
        echo "<h1>{$row['title']}</h1>";
        echo "<p>Category: {$row['category']}</p>";
        echo "<p>Instructions: {$row['instructions']}</p>";
        echo "<img src='{$row['image']}' alt='Recipe Image'>";
        echo "<p>Chef Name: {$row['chefname']}</p>";
        echo "<p>Location: {$row['location']}</p>";
        echo "<p>Recipe ID: {$row['recipeid']}</p>";

        // Create a link to mainpage.html
        echo "<p><a href='mainpage.html'>Back to Main Page</a></p>";
    } else {
        // Display an error message if no recipe found for the provided ID
        echo "<p>No recipe found for the provided ID</p>";
    }

    // Close the database connection
    mysqli_close($connection);
} else {
    // Display an error message if recipe ID is not provided in the query string
    echo "<p>Recipe ID is missing</p>";
}
?>
</body>
</html>
