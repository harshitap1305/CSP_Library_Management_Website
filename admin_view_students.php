<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

require 'db_connection.php';

$sql = "SELECT * FROM students";
$result = $dbConn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
</head>
<body>
    <h1>Student Data</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
