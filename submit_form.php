<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost:3308"; // Ensure this is correct
$username = "root";
$password = "";
$dbname = "portfolio_db"; // Use your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize input
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $message = $conn->real_escape_string($_POST['message']);

    // Prepare SQL query to insert data into the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $message);

    // Execute the query and check the result
    if ($stmt->execute()) {
        // Success message
        echo "<script>
                alert('Message sent successfully!');
                window.location.href = 'index.html'; // Redirect to the homepage or any other page
              </script>";
    } else {
        // Error message with detailed error from the query
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.history.back(); // Go back to the form page
              </script>";
    }

    // Close the prepared statement and connection
    $stmt->close();
    $conn->close();
}
?>
