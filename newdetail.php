<?php
session_start();

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "projekt"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Chyba připojení k databázi: " . $conn->connect_error);
}

$blog_id = isset($_GET['blog_id']) ? intval($_GET['blog_id']) : 0;

if ($blog_id === 0) {
    die("Neplatné ID blogu.");
}

$sql = "SELECT title, text, `nazev-obr` FROM blog WHERE blog_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();

$blog_detail = $result->fetch_assoc();

if (!$blog_detail) {
    die("Blog nenalezen.");
}

$image_path = htmlspecialchars($blog_detail['nazev-obr']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="detail.css">
    <title><?php echo htmlspecialchars($blog_detail['title']); ?></title>
</head>
<body>
    <header>
        <div class="a"><a href="novinky.php">Zpět</a></a></div>
        <div class="hl"><h1><?php echo htmlspecialchars($blog_detail['title']); ?></h1></div>
    </header>
    <main>
        <div class="container">
            <p><?php echo nl2br(htmlspecialchars($blog_detail['text'])); ?></p>
            <img src="<?php echo $image_path; ?>" alt="Obrázek blogu" class="blog-image">
            <a href="editor.php?blog_id=<?php echo $blog_id; ?>">Upravit</a>
        </div>
    </main>
</body>
</html>
