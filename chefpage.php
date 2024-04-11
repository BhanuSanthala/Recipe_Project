<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Manager</title>
    <link rel="stylesheet" href="chefpagestyle.css">
</head>
<body>

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

// Check if form is submitted for adding recipe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addRecipe"])) {
    // Retrieve form data
    $title = $_POST['title'];
    $category = $_POST['category'];
    $instructions = $_POST['instructions'];
    $chef_name = $_POST['chef_name'];
    $location = $_POST['location'];

    // File upload handling
    $targetDirectory = "C:/xampp/htdocs/Recipe_project/images/"; // Directory where images will be stored
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br>";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.<br>";

            // Prepare SQL statement to insert data into the database
            $stmt = $conn->prepare("INSERT INTO rd_table (title, category, instructions, chefname, location, image) VALUES (?, ?, ?, ?, ?, ?)");

            // Bind parameters
            $stmt->bind_param("ssssss", $title, $category, $instructions, $chef_name, $location, $targetFile);

            // Execute the statement
            if ($stmt->execute()) {
                echo "Recipe added successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
}

// Check if form is submitted for updating recipe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateRecipe"])) {
    // Retrieve form data
    $update_id = $_POST['update-id'];
    $update_title = $_POST['update-title'];
    $update_category = $_POST['update-category'];
    $update_instructions = $_POST['update-instructions'];
    $update_chef_name = $_POST['update-chef-name'];
    $update_location = $_POST['update-location'];

    // Prepare SQL statement to update data in the database
    $stmt = $conn->prepare("UPDATE rd_table SET title=?, category=?, instructions=?, chefname=?, location=? WHERE id=?");

    // Bind parameters
    $stmt->bind_param("sssssi", $update_title, $update_category, $update_instructions, $update_chef_name, $update_location, $update_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Recipe updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Check if form is submitted for deleting recipe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteRecipe"])) {
    // Retrieve recipe ID to be deleted
    $delete_id = $_POST['delete-id'];

    // Prepare SQL statement to delete data from the database
    $stmt = $conn->prepare("DELETE FROM rd_table WHERE recipeid=?");

    // Bind parameters
    $stmt->bind_param("i", $delete_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Recipe deleted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!-- Form for adding a recipe -->
<h2>Add Recipe</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" required><br>
    <input type="text" name="category" placeholder="Category" required><br>
    <textarea name="instructions" placeholder="Instructions" required></textarea><br>
    <input type="text" name="chef_name" placeholder="Chef Name" required><br>
    <input type="text" name="location" placeholder="Location" required><br>
    <input type="file" name="image" accept="image/*" required><br>
    <input type="submit" name="addRecipe" value="Add Recipe">
</form>

<!-- Form for updating a recipe -->
<h2>Update Recipe</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="text" name="update-title" placeholder="Title" required><br>
    <input type="text" name="update-category" placeholder="Category" required><br>
    <textarea name="update-instructions" placeholder="Instructions" required></textarea><br>
    <input type="text" name="update-chef-name" placeholder="Chef Name" required><br>
    <input type="text" name="update-location" placeholder="Location" required><br>
    <input type="hidden" name="update-id">
    <input type="submit" name="updateRecipe" value="Update Recipe">
</form>

<!-- Form for deleting a recipe -->
<h2>Delete Recipe</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="text" name="delete-id" placeholder="Recipe ID to Delete" required><br>
    <input type="submit" name="deleteRecipe" value="Delete Recipe">
</form>
</body>
</html>