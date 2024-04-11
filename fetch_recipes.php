<?php
// Database connection (replace with your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe_details";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all fields from the rd_table
$sql = "SELECT title, category, image, chefname, location, recipeid FROM rd_table";
$result = $conn->query($sql);

$recipes = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $recipe = array(
            "title" => $row["title"],
            "category" => $row["category"],
            "image" => $row["image"],
            "chefname" => $row["chefname"],
            "location" => $row["location"],
            "recipeid" => $row["recipeid"]
        );
        $recipes[] = $recipe;
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();

// Output JSON formatted data
header('Content-Type: application/json');
echo json_encode($recipes);
?>
