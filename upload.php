<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "projekt";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if(isset($_FILES['image'])) {
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    
    $total = count($_FILES['image']['name']);
    for($i=0; $i<$total; $i++) {
        $file_name = $_FILES['image']['name'][$i];
        $file_tmp = $_FILES['image']['tmp_name'][$i];
        $file_type = $_FILES['image']['type'][$i];
        
        $file_info = pathinfo($file_name);
        $file_ext = strtolower($file_info['extension']);
        
        if(in_array($file_ext, $allowed_extensions) === false) {
            echo 'Chyba: Nepodporovaný formát souboru.';
        } else {
            $user_id = $_SESSION['user_id']; 
            $pictures_name = $_POST['name'];; 
            $img_dir = 'uploads/' . $file_name; 
    
            $sql = "INSERT INTO gallery (pictures_name, img_dir, user_id) VALUES ('$pictures_name', '$img_dir', '$user_id')";
            if ($conn->query($sql) === TRUE) {
                move_uploaded_file($file_tmp, 'pictures/' . $file_name);
                echo "<script> alert('Image uploaded successfully.') </script>";
                echo "<script> window.location.href = 'galerie.php'; </script>";
                echo "<script>window.opener.location.reload();</script>";
            } else {
                echo "<script> alert('Error. The image did not upload.') </script>";
                echo "<script> window.location.href = 'galerie.php'; </script>";
                echo "<script>window.opener.location.reload();</script>";
            }
        }
    }
}

$conn->close();
?>
