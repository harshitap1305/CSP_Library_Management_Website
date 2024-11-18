<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

require 'config.php';
include 'navbar.php';
// Check if the database connection was successful
if (!$dbConn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM students";
$result = $dbConn->query($sql);

// Check for query errors
if (!$result) {
    die("Error executing query: " . $dbConn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
</head>
<body>
    <h1>Student Data</h1>
    <?php if ($result->num_rows > 0) { ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No students found in the database.</p>
    <?php } ?>
</body>
</html>
<?php
// Close the database connection
$dbConn->close();
?>
