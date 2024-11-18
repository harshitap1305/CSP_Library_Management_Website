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
    $query = "DELETE FROM booklist WHERE id = ?";
    $stmt = $dbConn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('i', $book_id); // 'i' indicates an integer parameter
        if ($stmt->execute()) {
            echo "Book deleted successfully!";
            echo '<a href="admin_dashboard.html">Back to Dashboard</a>';
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
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
        color: #3A3A3A;
        font-size: 28px;
        margin-top: 30px;
    }

    form {
        background-color: #fff;
        padding: 30px;
        margin: 0 auto;
        width: 60%;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    label {
        font-size: 16px;
        color: #333;
        margin-top: 10px;
    }

    input[type="number"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
    }

    button {
        width: 100%;
        padding: 15px;
        background-color: #305B65; /* Button color */
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #4CAF50; /* Optional hover effect */
    }

    #back_link {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #4CAF50;
        font-size: 18px;
    }

    #back_link:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        form {
            width: 80%;
        }
    }
</style>

</head>
<body>
    <h1>Delete Book</h1>
    <form action="admin_delete_book.php" method="POST">
        <label for="book_id">Book ID:</label>
        <input type="number" name="book_id" required>
        <button type="submit">Delete</button>
    </form>
</body>
</html>
