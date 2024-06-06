<?php
$servername = "localhost";
$username = "root";
$password = "";
$databasename = "projekt";

$conn = new mysqli($servername, $username, $password, $databasename);

if ($conn->connect_error) {
    die("Connection failed: "  . $conn->connect_error);
}

if($_POST){ 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nickname = $_POST["nickname"];
        $password = $_POST["password"];

        $nickname = mysqli_real_escape_string($conn, $nickname);

        $sql_check_user = "SELECT * FROM users WHERE nickname = '$nickname'";
        $result_check_user = $conn->query($sql_check_user);

        if ($result_check_user->num_rows == 1) {
            $row = $result_check_user->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                session_start();
                $_SESSION['user_id'] = $row["id"];
                $_SESSION["user_email"] = $row["email"];
                $_SESSION["user_nickname"] = $row["nickname"];
                echo "<script> alert('Úspěšně přihlášen') </script>";
                echo "<script> window.location.href = 'admin.html'; </script>";
                echo "<script>window.opener.location.reload();</script>";
                exit();
            } else {
                echo "<script> alert('Wrong password.') </script>";
                echo "<script> window.location.href = 'index.html'; </script>";
                exit();
            }
        } else {
            echo "<script> alert('User not found.') </script>";
            echo "<script> window.location.href = 'index.html'; </script>";
            exit();
        }
    }
}

$conn->close();
?>
