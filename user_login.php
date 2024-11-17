<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $dbConn->real_escape_string($_POST['email']);
    $password = $dbConn->real_escape_string($_POST['password']);
    $sql = "SELECT * FROM user_info WHERE user_email='$email' AND userPassword='$password'";
    $result = $dbConn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $email;
        header("Location: user_dashboard.php");
    } else {
        echo "<p>Invalid credentials</p>";
    }
}
$dbConn->close();
?>