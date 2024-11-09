<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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
        <a href="dashboard.php">Home</a>
        <a href="add_book.php">Add Books</a>
        <a href="edit_books.php">Edit Books</a>
        <a href="delete_books.php">Delete Books</a>
        <a href="view_requests.php">View Issue Requests</a>
        <a href="book_list.php">Book List</a>
        <a href="student_data.php">View Student Data</a>
        <a href="issued_books.php">Currently Issued Books</a>
        <a href="logout.php">Logout</a>
    </div>

    <h1>Welcome to the Library Dashboard</h1>
    <p>Select an option from the menu to manage the library system.</p>

</body>
</html>

