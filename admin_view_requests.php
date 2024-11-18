<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

require 'config.php';
include 'navbar.php';

// Ensure a valid database connection
if (!$dbConn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM issue_requests";
$result = $dbConn->query($sql);

if (!$result) {
    die("Error executing query: " . $dbConn->error);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>View Issue Requests</title>
</head>
<body>
    <h1>Issue Requests</h1>
    <?php if ($result->num_rows > 0) { ?>
        <table border="1">
            <tr>
                <th>Request ID</th>
                <th>Book ID</th>
                <th>Student ID</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['book_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No issue requests found.</p>
    <?php } ?>
</body>
</html>
<?php
// Close the database connection
$dbConn->close();
?>
