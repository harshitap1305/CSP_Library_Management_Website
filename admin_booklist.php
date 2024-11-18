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

if (!$rResult) {
    die("Error executing query: " . $dbConn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book List</title>
</head>
<body>
    <h1>Book List</h1>
    
    <?php if ($rResult->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Quantity</th>
            </tr>
            <?php while ($rRow = $rResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($rRow['id']); ?></td>
                    <td><?php echo htmlspecialchars($rRow['book_title']); ?></td>
                    <td><?php echo htmlspecialchars($rRow['author']); ?></td>
                    <td><?php echo htmlspecialchars($rRow['quantity']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No books found.</p>
    <?php endif; ?>

    <?php $dbConn->close(); ?>
</body>
</html>
