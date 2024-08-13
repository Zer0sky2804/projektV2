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

$user_id = $_SESSION['user_id']; 

$sql = "SELECT * FROM gallery WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $image_path =  $row["img_dir"]; 
        echo '<img src="' . $image_path . '" alt="' . $row["pictures_name"] . '">';
        echo '<p>' . $row["pictures_name"] . '</p>'; 
    }
} else {
    echo "No images found.";
}

$conn->close();
?>
