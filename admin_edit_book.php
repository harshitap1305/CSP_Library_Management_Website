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
                echo '<a href="admin_dashboard.html">Back to Dashboard</a>';
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
    <style>
        body {
            font-family: "Merriweather", Arial, sans-serif;
            background-color: #F8F0E3;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            color: #305B65;
            font-family: "Playfair Display", Georgia, serif;
        }
        form {
            max-width: 500px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        select, input, button {
            display: block;
            width: calc(100% - 20px);
            margin: 10px auto;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-family: "Merriweather", Arial, sans-serif;
        }
        select {
            background-color: #fff;
        }
        input:focus, select:focus {
            border-color: #AD6A48;
            outline: none;
        }
        button {
            background-color: #AD6A48;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        button:hover {
            background-color: #915638;
            transform: translateY(-3px);
        }
        button:active {
            background-color: #78472e;
            transform: translateY(0);
        }
        /* Responsive adjustments */
        @media (max-width: 600px) {
            form {
                padding: 15px;
            }
            h1 {
                font-size: 22px;
            }
            select, input, button {
                width: calc(100% - 30px);
            }
        }
    </style>
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
