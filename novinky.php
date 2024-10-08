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

$sql = "SELECT blog_id, title FROM blog WHERE user_id = ?";
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
    <link rel="stylesheet" href="novinky.css">
    <title>Novinky</title>
</head>
<body>
    <header>
    <div class="a"><a href="admin.php">Hlavní stránka</a></div>
    <div class="hl"><hl class="hl">Novinky</hl></div>
    </header>
    <main>
        <div class="container">
            <?php
            foreach ($buttons as $button) {
                echo '<form action="newdetail.php" method="get">';
                echo '<input type="hidden" name="blog_id" value="' . htmlspecialchars($button['blog_id']) . '">';
                echo '<button type="submit">' . htmlspecialchars($button['title']) . '</button>';
                echo '</form>';
                
            }
        ?>
        </div>
    </main>
</body>
</html>
