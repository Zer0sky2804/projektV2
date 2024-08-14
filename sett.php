<?php
// Připojení k databázi
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}

// Inicializace proměnné pro zprávu
$message = "";

// Zpracování odeslání formuláře pro změnu meta tagů
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_meta'])) {
    $meta = $conn->real_escape_string($_POST['meta']);
    $sql = "UPDATE sett SET metatagy='$meta' WHERE id=1";
    if ($conn->query($sql) === TRUE) {
        $message = "Meta tagy úspěšně aktualizovány.";
    } else {
        $message = "Chyba při aktualizaci meta tagů: " . $conn->error;
    }
    // Přesměrování s přenesením zprávy
    header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . urlencode($message));
    exit();
}

// Zpracování odeslání formuláře pro změnu klíčových slov
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_keywords'])) {
    $keywords = $conn->real_escape_string($_POST['keywords']);
    $sql = "UPDATE sett SET keywords='$keywords' WHERE id=1";
    if ($conn->query($sql) === TRUE) {
        $message = "Klíčová slova úspěšně aktualizována.";
    } else {
        $message = "Chyba při aktualizaci klíčových slov: " . $conn->error;
    }
    // Přesměrování s přenesením zprávy
    header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . urlencode($message));
    exit();
}

// Načtení aktuálních hodnot z databáze
$sql = "SELECT metatagy, keywords FROM sett WHERE id=1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_meta = $row['metatagy'];
    $current_keywords = $row['keywords'];
} else {
    $current_meta = "";
    $current_keywords = "";
}

$conn->close();

// Zpracování zprávy z URL
$message = isset($_GET['message']) ? urldecode($_GET['message']) : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sett.css">
    <title>Nastavení</title>
</head>
<body>
    <div class="header">
        <div class="a"><a href="admin.php">Hlavní stránka</a></div>
        <div class="hl"><hl class="hl">Nastavení</hl></div>
    </div>
    <div class="table" id="table">
        <!-- Formulář pro změnu meta tagů -->
        <div id="meta-form">
            <form action="" method="post">
                <label for="meta">Meta tagy:</label>
                <input type="text" id="meta" name="meta" value="<?php echo htmlspecialchars($current_meta); ?>" required>
                <button type="submit" name="update_meta">Potvrdit</button>
            </form>
        </div>

        <!-- Formulář pro změnu klíčových slov -->
        <div id="keywords-form">
            <form action="" method="post">
                <label for="keywords">Klíčová slova:</label>
                <input type="text" id="keywords" name="keywords" value="<?php echo htmlspecialchars($current_keywords); ?>" required>
                <button type="submit" name="update_keywords">Potvrdit</button>
            </form>
        </div>
    </div>

    <script>
        // Zobrazit zprávu o úspěchu nebo chybě, pokud je k dispozici
        const message = "<?php echo addslashes($message); ?>";
        if (message) {
            alert(message);
        }
    </script>
</body>
</html>
