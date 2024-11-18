<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

require 'config.php';
include 'navbar.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sSql = "SELECT issued_books.book_id, books.book_title, issued_books.student_id, students.name 
         FROM issued_books
         INNER JOIN books ON issued_books.book_id = books.id
         INNER JOIN students ON issued_books.student_id = students.id";

$rResult = $dbConn->query($sSql);

if (!$rResult) {
    die("Query Failed: " . $dbConn->error);
}

// Fetch all results into an array for reuse
$issuedBooks = [];
if ($rResult->num_rows > 0) {
    while ($rRow = $rResult->fetch_assoc()) {
        $issuedBooks[] = $rRow; // Store each row in an array
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
        <?php if (!empty($issuedBooks)) { ?>
            <?php foreach ($issuedBooks as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['book_title']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="2">No records found.</td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
