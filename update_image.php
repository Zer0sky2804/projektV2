<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projekt";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_FILES['image'])) {
    $file_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_info = pathinfo($file_name);
    $file_ext = strtolower($file_info['extension']);
    
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    
    if (in_array($file_ext, $allowed_extensions) === false) {
        echo 'Chyba: Nepodporovaný formát souboru.';
        exit;
    }
    
    $pic_dir = 'pic_admin/' . $file_name;

    $sql = "UPDATE admin SET pic_dir='$pic_dir' WHERE id=1";
    if ($conn->query($sql) === TRUE) {
        if (!is_dir('pic_admin')) {
            mkdir('pic_admin', 0777, true);
        }
        move_uploaded_file($file_tmp, $pic_dir);
        echo 'Obrázek byl úspěšně aktualizován.';
    } else {
        echo 'Chyba: Obrázek nebyl aktualizován.';
    }
}

$conn->close();
?>
