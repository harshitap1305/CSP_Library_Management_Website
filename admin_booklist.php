<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

require 'config.php';
include 'navbar.php';

// Query to fetch all books from the booklist table
$sSql = "SELECT * FROM booklist";

$rResult = $dbConn->query($sSql);

if (!$rResult) {
    die("Error executing query: " . $dbConn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book List</title>
    <style>
        body {
            font-family: "Merriweather", Arial, sans-serif;
            background-color: #F8F0E3;
            margin: 0;
            padding: 0;
        }
        h1 {
            margin-top: 20px;
            color: #305B65;
            font-family: "Playfair Display", Georgia, serif;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #AD6A48;
            color: white;
            font-weight: bold;
        }
        td {
            font-size: 14px;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #F8F0E3;
        }
        tr:hover {
            background-color: #EFE2D4;
        }
        p {
            text-align: center;
            font-size: 16px;
            color: #666;
        }
        /* Responsive adjustments */
        @media (max-width: 600px) {
            table {
                width: 100%;
            }
            th, td {
                padding: 10px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body> 
<a href="admin_dashboard.html">Back to Dashboard</a>
    <h1>Book List</h1>
    
    <?php if ($rResult->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Shelf No</th>
                <th>Quantity</th>
                <th>Available</th>
                <th>Year Published</th>
                <th>Language</th>
            </tr>
            <?php while ($rRow = $rResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($rRow['id']); ?></td>
                    <td><?php echo htmlspecialchars($rRow['bookName']); ?></td>
                    <td><?php echo htmlspecialchars($rRow['authorName']); ?></td>
                    <td><?php echo htmlspecialchars($rRow['genre']); ?></td>
                    <td><?php echo htmlspecialchars($rRow['shelfNo']); ?></td>
                    <td><?php echo htmlspecialchars($rRow['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($rRow['remain']); ?></td> <!-- Available books -->
                    <td><?php echo htmlspecialchars($rRow['year_published']); ?></td>
                    <td><?php echo htmlspecialchars($rRow['language']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No books found.</p>
    <?php endif; ?>

    <?php $dbConn->close(); ?>
</body>
</html>
