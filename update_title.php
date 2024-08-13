<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newTitle = $_POST["title"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projekt";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Připojení selhalo: " . $conn->connect_error);
    }

    $sql = "UPDATE admin SET nadpis = ? WHERE id = 1"; 
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
