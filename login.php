<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$databasename = "projekt";

$conn = new mysqli($servername, $username, $password, $databasename);

if ($conn->connect_error) {
    die("Something went wrong. Please try again later.: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST["nickname"];
    $password = $_POST["password"];

    $nickname = mysqli_real_escape_string($conn, $nickname);

    $sql_check_user = "SELECT * FROM users WHERE nickname = '$nickname'";
    $result_check_user = $conn->query($sql_check_user);

    if ($result_check_user->num_rows == 1) {
        $row = $result_check_user->fetch_assoc();

        if (password_verify($password, $row["password"])) {
            $_SESSION['user_id'] = $row["id"];
            $_SESSION["user_email"] = $row["email"];
            $_SESSION["user_nickname"] = $row["nickname"];
            echo "<script>alert('Úspěšně přihlášen.')</script>";
            echo "<script>window.location.href = 'admin.html';</script>";
            exit();
        } else {
            echo "<script>alert('Špatné heslo.')</script>";
            echo "<script>window.location.href = 'index.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Uživatel nenalezen.')</script>";
        echo "<script>window.location.href = 'index.html';</script>";
        exit();
    }
}

$conn->close();
?>
