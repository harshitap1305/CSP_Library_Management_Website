<?php

session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    echo "User not logged in. Redirecting...";
    header("Location: admin_login.php");
    exit();
}

include 'config.php'; 
include 'navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Fetch form data
    $bookName = $_POST['bookName'];
    $authorName = $_POST['authorName'];
    $genre = $_POST['genre'];
    $shelfNo = $_POST['shelfNo'];
    $quantity = $_POST['quantity'];
    $year_published = $_POST['year_published'];
    $language = $_POST['language'];

    // Calculate `remain` as the initial quantity
    $remain = $quantity;

    if (!$dbConn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // SQL to insert into `booklist`
    $sql = "INSERT INTO booklist (bookName, authorName, genre, shelfNo, status_book, quantity, year_published, language, remain) 
            VALUES (?, ?, ?, ?, TRUE, ?, ?, ?, ?)";
    $stmt = $dbConn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param('sssiiisi', $bookName, $authorName, $genre, $shelfNo, $quantity, $year_published, $language, $remain);

        // Execute the statement
        if ($stmt->execute()) {
            echo "New book added successfully!";
            echo '<a href="admin_dashboard.html">Back to Dashboard</a>';
        } else {
            echo "Error executing statement: " . $stmt->error;
        }

        $stmt->close();
    } else {
        die("Error preparing the query: " . $dbConn->error);
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

        input[type="text"], input[type="number"] {
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
            background-color: #305B65;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #305B65;
        }

        #back_link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color:#305B65;
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
    <h1>Add a New Book</h1>
    <a id="back_link" href="admin_dashboard.html">Back to Dashboard</a>
    <form action="admin_add_book.php" method="POST">
        <label for="bookName">Book Name:</label>
        <input type="text" name="bookName" required><br>

        <label for="authorName">Author Name:</label>
        <input type="text" name="authorName" required><br>

        <label for="genre">Genre:</label>
        <input type="text" name="genre" required><br>

        <label for="shelfNo">Shelf Number:</label>
        <input type="number" name="shelfNo" required><br>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required><br>

        <label for="year_published">Year Published:</label>
        <input type="number" name="year_published"><br>

        <label for="language">Language:</label>
        <input type="text" name="language" required><br>

        <button type="submit">Add Book</button>
    </form>
</body>
</html>
