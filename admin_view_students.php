<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

require 'config.php';


// Check if the database connection was successful
if (!$dbConn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch student data from the user_info table
$sql = "SELECT * FROM user_info";
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
    <style>
        body {
            font-family: "Merriweather", Arial, sans-serif;
            background-color: #F8F0E3;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include('navbar.php'); ?>
    <h1>Student Data</h1>
    <?php if ($result->num_rows > 0) { ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Degree</th>
                <th>Mobile</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td> <!-- 'user_id' instead of 'id' -->
                    <td><?php echo htmlspecialchars($row['user_name']); ?></td> <!-- 'user_name' instead of 'name' -->
                    <td><?php echo htmlspecialchars($row['user_email']); ?></td> <!-- 'user_email' instead of 'email' -->
                    <td><?php echo htmlspecialchars($row['user_department']); ?></td> <!-- 'user_department' -->
                    <td><?php echo htmlspecialchars($row['user_degree']); ?></td> <!-- 'user_degree' -->
                    <td><?php echo htmlspecialchars($row['user_mobile']); ?></td> <!-- 'user_mobile' -->
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
