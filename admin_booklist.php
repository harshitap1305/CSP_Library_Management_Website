<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

require 'config.php';
include 'navbar.php';

$sSql = "SELECT * FROM books";


$rResult = $dbConn->query($sSql);


if ($rResult->num_rows > 0) {
   
    while ($rRow = $rResult->fetch_assoc()) {
    
        echo "Book ID: " . $rRow['id'] . " | Title: " . $rRow['book_title'] . " | Author: " . $rRow['author'] . "<br>";
    }
} else {
    echo "No books found.";
}


$dbConn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book List</title>
</head>
<body>
    <h1>Book List</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Quantity</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['author']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
