<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

require 'db_connection.php';

$sql = "SELECT * FROM issue_requests";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Issue Requests</title>
</head>
<body>
    <h1>Issue Requests</h1>
    <table border="1">
        <tr>
            <th>Request ID</th>
            <th>Book ID</th>
            <th>Student ID</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['book_id']; ?></td>
                <td><?php echo $row['student_id']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
