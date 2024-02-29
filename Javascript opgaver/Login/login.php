<?php
// Ændring 2: Tjek for POST-metoden
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        // Ændring 3: Brug $_POST til at hente data
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

    // Ændring 4: Send tekstrespons tilbage til klienten
    echo $response;

    $conn->close();
} else {
    // Ændring 5: Send 405-fejlkode, hvis metoden ikke er POST
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Method Not Allowed';
}
?>