<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

include 'config.php';

$admin_email = $_SESSION['admin_logged_in'];

// Check database connection
if (!$dbConn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch books for the dropdown
$query = "SELECT id, book_title FROM books";
$result = $dbConn->query($query);
if (!$result) {
    die("Error fetching books: " . $dbConn->error);
}

// Handle form submission to update books
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $quantity = $_POST['quantity'];

    $updateQuery = "UPDATE books SET book_title = ?, author = ?, quantity = ? WHERE id = ?";
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Books</title>
</head>
<body>
    <h1>Edit Books</h1>
    <form method="post">
        <select name="book_id">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                    <?php echo htmlspecialchars($row['book_title']); ?>
                </option>
            <?php } ?>
        </select><br>
        <input type="text" name="title" placeholder="Title"><br>
        <input type="text" name="author" placeholder="Author"><br>
        <input type="number" name="quantity" placeholder="Quantity"><br>
        <button type="submit">Update Book</button>
    </form>
</body>
</html>

