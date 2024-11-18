<?php
include 'config.php';
include 'navbar.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];

    // Check if book_id is set and numeric
    if (!isset($book_id) || !is_numeric($book_id)) {
        echo "Invalid Book ID.";
        exit();
    }

    // Prepare the DELETE query
    $query = "DELETE FROM books WHERE id = ?";
    $stmt = $dbConn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('i', $book_id); // 'i' indicates an integer parameter
        if ($stmt->execute()) {
            echo "Book deleted successfully!";
        } else {
            echo "Error executing query: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing query: " . $dbConn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Book</title>
</head>
<body>
    <h1>Delete Book</h1>
    <form action="delete_book.php" method="POST">
        <label for="book_id">Book ID:</label>
        <input type="number" name="book_id" required>
        <button type="submit">Delete</button>
    </form>
</body>
</html>
