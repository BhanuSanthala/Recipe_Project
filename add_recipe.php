// Check if form is submitted for adding recipe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addRecipe"])) {
    // Retrieve form data
    $title = $_POST['title'];
    $category = $_POST['category'];
    $instructions = $_POST['instructions'];
    $chef_name = $_POST['chef_name'];
    $location = $_POST['location'];
    // Add more fields as needed

    // File upload handling
    $targetDirectory = "http://localhost/Recipe_project/images/"; // Directory where images will be stored
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
            // Prepare SQL statement to insert data into the database
            $stmt = $conn->prepare("INSERT INTO recipes (title, category, instructions, chef_name, location, image_path) VALUES (?, ?, ?, ?, ?, ?)");

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
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
