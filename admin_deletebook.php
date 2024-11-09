<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'library_system');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM books WHERE book_id='$book_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Book deleted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
</head>
<body>
    <h1>Delete a Book</h1>

    <form action="delete_books.php" method="GET">
        <label for="book_id">Enter Book ID to delete:</label>
        <input type="number" name="book_id" required><br>

        <button type="submit">Delete Book</button>
    </form>
</body>
</html>

