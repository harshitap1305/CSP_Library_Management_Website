<?php
session_start();
include 'navbar.php';
// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="navbar">
        <a href="home.html">Home</a>
        <a href="admin_add_book.php">Add Books</a>
        <a href="admin_edit_book.php">Edit Books</a>
        <a href="admin_delete_book.php">Delete Books</a>
        <a href="admin_view_requests.php">View Issue Requests</a>
        <a href="admin_booklist.php">Book List</a>
        <a href="admin_view_student.php">View Student Data</a>
        <a href="admin_currently_issued.php">Currently Issued Books</a>
        <a href="admin_logout.php">Logout</a>
    </div>

    <h1>Welcome to the Library Dashboard</h1>
    <p>Select an option from the menu to manage the library system.</p>

</body>
</html>

