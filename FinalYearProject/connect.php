<?php
if (!isset($_SESSION)) {
  session_start();
}

// Connect to database
$conn = mysqli_connect("localhost", "id14314173_fypsayed", "#AbuSayed59395", "id14314173_sayedfyp");
global $conn;

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
?>
