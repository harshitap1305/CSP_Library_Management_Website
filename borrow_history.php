<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: user_login.php");
    exit();
}

include 'config.php';

$user_email = $_SESSION['user'];

// Fetch borrow history
$query_history = "SELECT booklist.bookName, issues.issue_date, issues.return_date 
                  FROM issues 
                  JOIN booklist ON issues.book_id = booklist.id 
                  JOIN user_info ON issues.user_id = user_info.user_id 
                  WHERE user_info.user_email = ?";
$stmt_history = $dbConn->prepare($query_history);
$stmt_history->bind_param("s", $user_email);
$stmt_history->execute();
$result_history = $stmt_history->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow History</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        h1 {
    text-align: center;
    font-size: 36px;
    color: #305B65;
    margin: 30px 0;
}
        #back_link {
    display: block;
    text-align: center;
    font-size: 18px;
    color: #305B65;
    margin-bottom: 20px;
}
#back_link:hover {
    color: #1E3A3A;
}
/* Table Styling */
table {
    width: 80%;
    margin: 0 auto;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px 20px;
    text-align: center;
    border: 1px solid #ddd;
}

th {
    background-color: #AD6A48;
    color: white;
    font-size: 18px;
    font-weight: bold;
}

td {
    font-size: 16px;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Not returned yet text */
td:last-child {
    font-style: italic;
    color: #FF4500;
}
</style>
</head>
<body>
<?php include('navbar.php'); ?>
    <h1>Borrow History</h1>
    <a id="back_link" href="user_dashboard.php">Back to Dashboard</a>
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
