<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "projekt"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Chyba připojení k databázi: " . $conn->connect_error);
}


session_start();

if (!isset($_SESSION['user_id'])) {
    die("Uživatel není přihlášen.");
}

$current_user_id = $_SESSION['user_id'];


$sql = "SELECT id, title FROM tlacitka WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

$buttons = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $buttons[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novinky</title>
</head>
<body>
    <header>
        <h1>Novinky</h1>
    </header>
    <main>
        <?php
        foreach ($buttons as $button) {
            echo '<form action="detail.php" method="get">';
            echo '<input type="hidden" name="id" value="' . htmlspecialchars($button['id']) . '">';
            echo '<button type="submit">' . htmlspecialchars($button['title']) . '</button>';
            echo '</form>';
        }
        ?>
    </main>
</body>
</html>
