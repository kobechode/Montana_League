<?php
header('Content-Type: application/json');

// Database credentials
$host = 'localhost'; // Replace with your server hostname
$username = 'root';  // Replace with your MySQL username
$password = '';      // Replace with your MySQL password
$database = 'montana_league'; // Your database name

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Query to fetch team data
$sql = "SELECT Team, Win, Loss, Ppg FROM teams"; // Adjust table name if needed
$result = $conn->query($sql);

$teams = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teams[] = $row;
    }
}

// Return JSON data
echo json_encode($teams);

// Close the connection
$conn->close();
?>
