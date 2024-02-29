<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "Password1";
$database = "min_database";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    $response = 'Connection failed: ' . $conn->connect_error;
} else {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM brugere WHERE brugernavn = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $response = 'success';
    } else {
        $response = 'failure';
    }

    $stmt->close();
}

// Send tekstrespons tilbage til klienten
echo $response;

$conn->close();
?>