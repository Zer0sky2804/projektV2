<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="galerie.css">
    <title>Galerie</title>
</head>
<body>
    <div class="header">
        <div class="a"><a href="admin.php">Hlavní stránka</a></div>
        <div class="hl"><h1>Galerie</h1></div>
    </div>

    <div class="add-picture">
        <h2>Nahrát obrázek</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="image[]" id="image" multiple>
            <br>
            <label for="name">Název obrázku:</label>
            <input type="text" id="name" name="name" required>
            <br><br>
            <button type="submit">Potvrdit</button>
        </form>
    </div>
    
    <div class="gallery">
        <h2>Obrázky na stránce</h2>
        <?php include 'load.php'; ?>
    </div>
</body>
</html>
