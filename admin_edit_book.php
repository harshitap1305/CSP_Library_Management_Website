<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

require 'config.php';
include 'navbar.php';

// Check database connection before any query
if (!$dbConn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch books for the dropdown
$query = "SELECT id, bookName FROM booklist";  // 'bookName' instead of 'book_title'
$result = $dbConn->query($query);
if (!$result) {
    die("Error fetching books: " . $dbConn->error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $quantity = $_POST['quantity'];

    // Validate form data
    if (empty($book_id) || empty($title) || empty($author) || empty($quantity)) {
        echo "All fields are required.";
    } else {
        // Update the book details (Update 'bookName', 'authorName', 'quantity' instead of 'book_title', 'author', 'quantity')
        $updateQuery = "UPDATE booklist SET bookName = ?, authorName = ?, quantity = ? WHERE id = ?";  // 'bookName' and 'authorName' instead of 'book_title' and 'author'
        $stmt = $dbConn->prepare($updateQuery);
        if ($stmt) {
            $stmt->bind_param('ssii', $title, $author, $quantity, $book_id);
            if ($stmt->execute()) {
                echo "Book updated successfully!";
            } else {
                echo "Error updating book: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing query: " . $dbConn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Books</title>
</head>
<body>
    <h1>Edit Books</h1>
    <form method="post">
        <select name="book_id">
            <option value="">Select a book</option>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                    <?php echo htmlspecialchars($row['bookName']); ?> <!-- 'bookName' instead of 'book_title' -->
                </option>
            <?php } ?>
        </select><br>

        <input type="text" name="title" placeholder="Title" required><br>
        <input type="text" name="author" placeholder="Author" required><br>
        <input type="number" name="quantity" placeholder="Quantity" required><br>

        <button type="submit">Update Book</button>
    </form>
</body>
</html>
