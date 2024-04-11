<?php
// Establish connection to MySQL database
$servername = "localhost"; // Change this to your server name if different
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "recipe"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully<br>"; // This line can help confirm the successful connection
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    // Prepare SQL statement to insert data into the database
    $stmt = $conn->prepare("INSERT INTO signup_tbl (username, email, phonenumber, password, address, role)
     VALUES (?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("ssssss", $username, $email, $phonenumber, $password, $address, $role);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Signup successful!";

        echo "<script>window.location = 'mainpage.html';</script>";

    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
