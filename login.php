<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Password for MySQL (if any)
$dbname = "recipe"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to check if user exists
    $sql = "SELECT * FROM signup_tbl WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        header("Location:mainpage.html");
        //echo "Login successful";
    } else {
        echo "Invalid username or password";
    }
}

$conn->close();
?>
