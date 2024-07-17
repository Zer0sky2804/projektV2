<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newTitle = $_POST["title"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projekt";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO admin (nadpis) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $newTitle);

    if ($stmt->execute()) {
        echo "Nadpis byl úspěšně změněn.";
    } else {
        echo "Chyba při změně nadpisu: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
