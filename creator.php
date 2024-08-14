<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "projekt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['blog-title'];
    $content = $_POST['blog-content'];
    $user_id = $_SESSION['user_id'];

    if (isset($_FILES['blog-image']) && $_FILES['blog-image']['error'] == 0) {
        $target_dir = "news/";
        $target_file = $target_dir . basename($_FILES["blog-image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_formats = ['jpg', 'jpeg', 'png', 'gif'];

        $check = getimagesize($_FILES["blog-image"]["tmp_name"]);
        if ($check !== false) {
            if (in_array($imageFileType, $allowed_formats) &&
                ($check['mime'] == 'image/jpeg' || $check['mime'] == 'image/png' || $check['mime'] == 'image/gif')) {
                if (move_uploaded_file($_FILES["blog-image"]["tmp_name"], $target_file)) {
                    $image_name = "news/" . basename($_FILES["blog-image"]["name"]); 
                } else {
                    echo "<script>alert('Chyba při uploudu.')</script>";
                    echo "<script>window.location.href = 'creator.html';</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Nahrál jsi špatný formát.')</script>";
                echo "<script>window.location.href = 'creator.html';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Nahrál jsi špatný formát.')</script>";
            echo "<script>window.location.href = 'creator.html';</script>";
            exit;
        }
    } else {
        $image_name = "";
    }
    
    $stmt = $conn->prepare("INSERT INTO blog (title, text, user_id, `nazev-obr`) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $title, $content, $user_id, $image_name);

    if ($stmt->execute()) {
        echo "<script>alert('Nový záznam úspěšně vytvořen.')</script>";
        echo "<script>window.location.href = 'admin.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
