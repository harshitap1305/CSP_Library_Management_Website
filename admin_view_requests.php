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

if (isset($_POST['approve']) || isset($_POST['reject'])) {
    $request_id = $_POST['request_id'];
    $new_status = isset($_POST['approve']) ? 'Approved' : 'Rejected';

    // Get the book ID and user ID for the requested book
    $sql_get_request = "SELECT * FROM requests WHERE id = $request_id";
    $request_result = $dbConn->query($sql_get_request);
    if ($request_result && $request_result->num_rows > 0) {
        $request_row = $request_result->fetch_assoc();
        $book_id = $request_row['book_id'];
        $user_id = $request_row['user_id'];

        if ($new_status == 'Approved') {
            // Check if the book is available (remain > 0)
            $sql_check_book = "SELECT remain FROM booklist WHERE id = $book_id";
            $book_result = $dbConn->query($sql_check_book);
            if ($book_result && $book_result->num_rows > 0) {
                $book_row = $book_result->fetch_assoc();
                if ($book_row['remain'] > 0) {
                    // Decrease the remain count in the booklist table
                    $sql_update_book = "UPDATE booklist SET remain = remain - 1 WHERE id = $book_id";
                    if ($dbConn->query($sql_update_book) === TRUE) {
                        // Insert into the issues table
                        $issue_date = date('Y-m-d');
                        $due_date = date('Y-m-d', strtotime('+14 days')); // Set due date as 14 days from today
                        $sql_insert_issue = "INSERT INTO issues (book_id, user_id, issue_date, due_date) 
                                             VALUES ($book_id, $user_id, '$issue_date', '$due_date')";
                        if ($dbConn->query($sql_insert_issue) === TRUE) {
                            // Update the request status to Approved
                            $sql_update_request = "UPDATE requests SET status = '$new_status' WHERE id = $request_id";
                            if ($dbConn->query($sql_update_request) === TRUE) {
                                echo "<p>Request approved. Book count updated and issued to user.</p>";
                            } else {
                                echo "<p>Error updating request status: " . $dbConn->error . "</p>";
                            }
                        } else {
                            echo "<p>Error issuing the book: " . $dbConn->error . "</p>";
                        }
                    } else {
                        echo "<p>Error updating book availability: " . $dbConn->error . "</p>";
                    }
                } else {
                    echo "<p>Book is not available for issue.</p>";
                }
            } else {
                echo "<p>Book not found.</p>";
            }
        } else {
            // If rejected, just update the status
            $sql_update_request = "UPDATE requests SET status = '$new_status' WHERE id = $request_id";
            if ($dbConn->query($sql_update_request) === TRUE) {
                echo "<p>Request status updated to $new_status.</p>";
            } else {
                echo "<p>Error updating request status: " . $dbConn->error . "</p>";
            }
        }
    } else {
        echo "<p>Request not found.</p>";
    }
}

$sql = "SELECT * FROM requests";
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
                <th>User ID</th>
                <th>Status</th>
                <th>Actions</th> <!-- New column for Actions -->
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['book_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <!-- Approve and Reject Buttons -->
                        <?php if ($row['status'] == 'Pending') { ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="approve">Approve</button>
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="reject">Reject</button>
                            </form>
                        <?php } ?>
                    </td>
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

