<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

require 'config.php';


$sSql = "SELECT issued_books.book_id, books.title, issued_books.student_id, students.name 
         FROM issued_books
         INNER JOIN books ON issued_books.book_id = books.id
         INNER JOIN students ON issued_books.student_id = students.id";


$rResult = $dbConn->query($sSql);


if ($rResult->num_rows > 0) {
    
    while ($rRow = $rResult->fetch_assoc()) {
        echo "Book ID: " . $rRow['book_id'] . " | Title: " . $rRow['title'] . " | Student ID: " . $rRow['student_id'] . " | Student Name: " . $rRow['name'] . "<br>";
    }
} else {
    echo "No records found.";
}


$dbConn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Currently Issued Books</title>
</head>
<body>
    <h1>Currently Issued Books</h1>
    <table border="1">
        <tr>
            <th>Book Title</th>
            <th>Student Name</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['name']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
