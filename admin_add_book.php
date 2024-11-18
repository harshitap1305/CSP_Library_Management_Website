<?php

session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: admin_login.php");
    exit();
}

include 'config.php'; 
include 'navbar.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_title = $_POST['book_title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $publisher = $_POST['publisher'];

   
    if (!$dbConn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    
    $sql = "INSERT INTO books (book_title, author, isbn, publisher) VALUES (?, ?, ?, ?)";
    $stmt = $dbConn->prepare($sql);

    if ($stmt) {
        
        $stmt->bind_param('ssss', $book_title, $author, $isbn, $publisher);

        
        if ($stmt->execute()) {
            echo "New book added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

       
        $stmt->close();
    } else {
        echo "Error preparing the query: " . $dbConn->error;
    }

  
    $dbConn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
</head>
<body>
    <h1>Add a New Book</h1>

    <form action="add_book.php" method="POST">
        <label for="book_title">Book Title:</label>
        <input type="text" name="book_title" required><br>

        <label for="author">Author:</label>
        <input type="text" name="author" required><br>

        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" required><br>

        <label for="publisher">Publisher:</label>
        <input type="text" name="publisher" required><br>

        <button type="submit">Add Book</button>
    </form>
</body>
</html>

