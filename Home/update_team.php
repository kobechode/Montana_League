<?php
// Database credentials
$servername = "localhost";
$username = "root"; // Replace with your username
$password = "";     // Replace with your password
$dbname = "montana_league";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update team data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_name = $_POST['Team'];
    $wins = $_POST['Win'];
    $losses = $_POST['Loss'];
    $ppg = $_POST['Ppg'];

    // Check if team exists
    $stmt = $conn->prepare("SELECT id FROM teams WHERE team_name = ?");
    $stmt->bind_param("s", $team_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update existing team
        $stmt = $conn->prepare("UPDATE teams SET Win = ?, Loss = ?, Ppg = ? WHERE team_name = ?");
        $stmt->bind_param("iiis", $wins, $losses, $ppg, $team_name);
    } else {
        // Insert new team
        $stmt = $conn->prepare("INSERT INTO teams (team_name, Wins, Loss, Ppg) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siii", $team_name, $wins, $losses, $ppg);
    }

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
