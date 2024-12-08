<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "daily_checklist";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$class = $_POST['class'];
$task = $_POST['task'];
$tool = $_POST['tool'];

$sql = "INSERT INTO tasks (class, task, tool) VALUES ('$class', '$task', '$tool')";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
