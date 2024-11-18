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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['penalty_submit'])) {
        // Add penalty
        $userId = $_POST['user_id'];
        $bookId = $_POST['book_id'];
        $penaltyAmount = $_POST['penalty_amount'];
        $reason = $_POST['reason'];

        $penaltySql = "INSERT INTO penalties (user_id, book_id, penalty_amount, reason, status) 
                       VALUES (?, ?, ?, ?, 'Unpaid')";

        $stmt = $dbConn->prepare($penaltySql);
        $stmt->bind_param('iids', $userId, $bookId, $penaltyAmount, $reason);

        if ($stmt->execute()) {
            echo "Penalty added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['mark_returned'])) {
        // Mark book as returned
        $issueId = $_POST['issue_id'];

        $returnSql = "UPDATE issues SET returned = TRUE, return_date = CURDATE() WHERE issue_id = ?";
        $stmt = $dbConn->prepare($returnSql);
        $stmt->bind_param('i', $issueId);

        if ($stmt->execute()) {
            echo "Book marked as returned successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Query to fetch currently issued books and user details
$sSql = "SELECT issues.issue_id, booklist.bookName, user_info.user_name, issues.issue_date, issues.due_date, issues.returned, 
                issues.book_id, issues.user_id
         FROM issues
         INNER JOIN booklist ON issues.book_id = booklist.id
         INNER JOIN user_info ON issues.user_id = user_info.user_id
         WHERE issues.returned = FALSE";

$rResult = $dbConn->query($sSql);

if (!$rResult) {
    die("Query Failed: " . $dbConn->error);
}

// Fetch issued books
$issuedBooks = [];
if ($rResult->num_rows > 0) {
    while ($rRow = $rResult->fetch_assoc()) {
        $issuedBooks[] = $rRow;
    }
}

// Fetch penalties for issued books
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
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #AD6A48;
            color: white;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Currently Issued Books</h1>
    <table>
        <tr>
            <th>Book Title</th>
            <th>Student Name</th>
            <th>Issue Date</th>
            <th>Due Date</th>
            <th>Penalty Status</th>
            <th>Actions</th>
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
                            $penaltyApplied = false;
                            foreach ($penalties as $penalty) {
                                if ($penalty['user_id'] == $row['user_id'] && $penalty['book_id'] == $row['book_id']) {
                                    $penaltyApplied = true;
                                    echo "₹" . htmlspecialchars($penalty['penalty_amount']) . " (" . htmlspecialchars($penalty['reason']) . ")";
                                }
                            }
                            if (!$penaltyApplied) {
                                echo "No Penalty Applied";
                            }
                        ?>
                    </td>
                    <td>
                        <form action="" method="POST" style="display: inline-block;">
                            <input type="hidden" name="issue_id" value="<?php echo htmlspecialchars($row['issue_id']); ?>">
                            <button type="submit" name="mark_returned">Mark Returned</button>
                        </form>
                        <form action="" method="POST" style="display: inline-block;">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($row['book_id']); ?>">
                            <input type="number" name="penalty_amount" placeholder="Penalty Amount" min="0" step="0.01" required>
                            <input type="text" name="reason" placeholder="Reason" required>
                            <button type="submit" name="penalty_submit">Add Penalty</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6">No currently issued books.</td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
