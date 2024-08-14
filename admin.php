<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogPage</title>
    <link rel="stylesheet" href="admin.css">

</head>
<body>
    <div id="header">
        <h1 id="page-title">/h1>
    </div>
    
    <div id="nav">
        <a href="creator.html">Creator</a>
        <a href="novinky.php">Novinky</a>
        <a href="galerie.php">Galerie</a>
        <a href="sett.php">Nastavení</a>
        <a href="register.html">Přidat uživatele</a>
        <a href="logout.php">Odhlásit se</a>
    </div>
    
    <div id="content">
        
        <div class="gallery-container">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "projekt";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Připojení selhalo: " . $conn->connect_error);
            }

            $sql = "SELECT pic_dir FROM admin WHERE pic_dir != ''";  
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="gallery-item">';
                    echo '<img src="' . htmlspecialchars($row["pic_dir"], ENT_QUOTES) . '" alt="Obrázek">';
                    echo '</div>';
                }
            } else {
                echo "Žádné obrázky nebyly nalezeny.";
            }

            $conn->close();
            ?>
        </div>

        <img id="uploaded-image" src="" alt="Obrázek" style="display:none;">
        <input type="file" id="file-input" accept="image/*" style="display:none;">
    </div>
    
    <div id="footer">
        <button id="change-title-button">Změnit Nadpis</button>
        <button id="change-image-button">Změnit Obrázek</button>
    </div>

    <script src="admin.js"></script>
</body>
</html>
