<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $dbConn->real_escape_string($_POST['email']);
    $password = $dbConn->real_escape_string($_POST['password']);
    $sql = "SELECT * FROM admin_info WHERE admin_email='$email' AND adminPassword='$password'";
    $result = $dbConn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $email;
        header("Location: admin_dashboard.html");
    } else {
        echo "<p>Invalid credentials</p>";
    }
}
$dbConn->close();
?>