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

// Handle penalty form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['penalty_submit'])) {
    $userId = $_POST['user_id'];
    $bookId = $_POST['book_id'];
    $penaltyAmount = $_POST['penalty_amount'];
    $reason = $_POST['reason'];

    // Insert penalty into the penalties table
    $penaltySql = "INSERT INTO penalties (user_id, book_id, penalty_amount, reason, status) 
                   VALUES ('$userId', '$bookId', '$penaltyAmount', '$reason', 'Unpaid')";

    if ($dbConn->query($penaltySql) === TRUE) {
        echo "Penalty added successfully.";
    } else {
        echo "Error: " . $dbConn->error;
    }
}

// Query to fetch currently issued books and user details
$sSql = "SELECT issues.issue_id, booklist.bookName, user_info.user_name, issues.issue_date, issues.due_date, issues.book_id, issues.user_id
         FROM issues
         INNER JOIN booklist ON issues.book_id = booklist.id
         INNER JOIN user_info ON issues.user_id = user_info.user_id
         WHERE issues.returned = FALSE"; // Only fetch currently issued books

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

// Query to get penalties for each issued book
$penaltyQuery = "SELECT * FROM penalties WHERE status = 'Unpaid'";
$penaltyResult = $dbConn->query($penaltyQuery);

$penalties = [];
if ($penaltyResult->num_rows > 0) {
    while ($penaltyRow = $penaltyResult->fetch_assoc()) {
        $penalties[] = $penaltyRow;
    }
}

$dbConn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Currently Issued Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
            color: #3A3A3A;
            font-size: 28px;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
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
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        form {
            display: flex;
            flex-direction: column;
            margin-top: 10px;
            align-items: center;
        }
        input[type="number"], input[type="text"] {
            padding: 8px;
            margin: 5px 0;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #45a049;
        }
        .no-records {
            text-align: center;
            color: #999;
            font-size: 16px;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            table {
                width: 100%;
            }
            th, td {
                font-size: 12px;
                padding: 10px;
            }
        }
    </style>
       
          
</head>
<body>
    <h1>Currently Issued Books</h1>
    <table border="1">
        <tr>
            <th>Book Title</th>
            <th>Student Name</th>
            <th>Issue Date</th>
            <th>Due Date</th>
            <th>Penalty Status</th>
            <th>Add Penalty</th>
        </tr>
        <?php if (!empty($issuedBooks)) { ?>
            <?php foreach ($issuedBooks as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['bookName']); ?></td>
                    <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['issue_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['due_date']); ?></td>
                    <td>
                        <?php
                            // Check if a penalty is already applied for this book
                            $penaltyApplied = false;
                            foreach ($penalties as $penalty) {
                                if ($penalty['user_id'] == $row['user_id'] && $penalty['book_id'] == $row['book_id']) {
                                    $penaltyApplied = true;
                                    echo "Penalty: ₹" . htmlspecialchars($penalty['penalty_amount']) . " (" . htmlspecialchars($penalty['reason']) . ")";
                                }
                            }
                            if (!$penaltyApplied) {
                                echo "No Penalty Applied";
                            }
                        ?>
                    </td>
                    <td>
                        <form action="" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($row['book_id']); ?>">
                            <label for="penalty_amount">Penalty Amount:</label>
                            <input type="number" name="penalty_amount" min="0" step="0.01" required>
                            <label for="reason">Reason:</label>
                            <input type="text" name="reason" required>
                            <button type="submit" name="penalty_submit">Add Penalty</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6">No records found.</td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>


