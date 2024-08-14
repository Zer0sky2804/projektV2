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

$title = $blog_detail['title'];
$content = $blog_detail['text'];
$image_name = $blog_detail['nazev-obr'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['blog-title']);
    $content = $conn->real_escape_string($_POST['blog-content']);
    
    if (isset($_FILES['blog-image']) && $_FILES['blog-image']['error'] === UPLOAD_ERR_OK) {
        $new_image_name = $conn->real_escape_string($_FILES['blog-image']['name']);
        $image_tmp_name = $_FILES['blog-image']['tmp_name'];
        $image_destination = 'uploads/' . $new_image_name;

        move_uploaded_file($image_tmp_name, $image_destination);

        $sql = "UPDATE blog SET title='$title', text='$content', `nazev-obr`='$new_image_name' WHERE blog_id=$blog_id";
    } else {
        $sql = "UPDATE blog SET title='$title', text='$content' WHERE blog_id=$blog_id";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: novinky.php");
        exit(); 
    } else {
        echo "Chyba při aktualizaci záznamu: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="creator.css">
    <title>Editor</title>
</head>
<body>
    <div class="header">
        <div class="a"><a href="novinky.php">Zpět</a></div>
        <div class="hl"><hl class="hl">Editor</hl></div>
    </div>
    <div class="table" id="table">
        
        <div id="blog-form">
            
            <form action="editor.php?blog_id=<?php echo $blog_id; ?>" method="post" enctype="multipart/form-data">
                <label for="blog-title">Nadpis:</label>
                <input type="text" id="blog-title" name="blog-title" value="<?php echo htmlspecialchars($title); ?>" required>
    
                <label for="blog-content">Kontent:</label>
                <textarea id="blog-content" name="blog-content" rows="8" required><?php echo htmlspecialchars($content); ?></textarea>

                <label for="blog-image">Vložit obrázek:</label>
                <input type="file" id="blog-image" name="blog-image" accept="image/*"><br><br>
                
                <?php if (!empty($image_name)): ?>
                    <img src="uploads/<?php echo htmlspecialchars($image_name); ?>" alt="Aktuální obrázek" style="max-width: 300px;">
                <?php endif; ?>

                <button type="submit">Potvrdit</button>
            </form>
        </div>
        
    </div>
</body>
</html>
