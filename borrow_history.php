<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: user_login.php");
    exit();
}

include 'config.php';

$user_email = $_SESSION['user'];

// Fetch borrow history
$query_history = "SELECT booklist.bookName AS title, issues.issue_date, issues.return_date 
                  FROM issues 
                  JOIN booklist ON issues.book_id = booklist.id 
                  JOIN user_info ON issues.user_email = user_info.user_email
                  WHERE user_info.user_email = ?";
$stmt_history = $dbConn->prepare($query_history);
$stmt_history->bind_param("s", $user_email);
$stmt_history->execute();
$result_history = $stmt_history->get_result();



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow History</title>
</head>
<body>
    <h1>Borrow History</h1>
    <a href="user_dashboard.php">Back to Dashboard</a>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Book Title</th>
                <th>Issued Date</th>
                <th>Return Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_history->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['issued_date']); ?></td>
                    <td><?php echo $row['return_date'] ? htmlspecialchars($row['return_date']) : "Not returned yet"; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
