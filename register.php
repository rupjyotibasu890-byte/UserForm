<?php
// Database configuration
$servername = "localhost";
$username = "root";      // your MySQL username
$password = "";          // your MySQL password
$dbname = "backend";     // ✅ using your existing database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data safely
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  // Hash the password before storing
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Prepare SQL statement
  $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

  if ($stmt) {
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
      echo "<h3 style='color:green;'>Registration successful!</h3>";
    } else {
      echo "<h3 style='color:red;'>Error: Could not execute query. " . $stmt->error . "</h3>";
    }

    $stmt->close();
  } else {
    echo "<h3 style='color:red;'>Error: Could not prepare statement. " . $conn->error . "</h3>";
  }
}

$conn->close();
?>
