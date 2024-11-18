<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: user_login.php");
    exit();
}

include 'config.php';

$user_email = $_SESSION['user'];

// Fetch user details
$query_user = "SELECT user_name, user_department, user_degree FROM user_info WHERE user_email = ?";
$stmt_user = $dbConn->prepare($query_user);
$stmt_user->bind_param("s", $user_email);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

// Fetch current books issued
$query_books = "SELECT booklist.bookName AS title 
                FROM issues 
                JOIN booklist ON issues.book_id = booklist.id 
                JOIN user_info ON issues.user_id = user_info.user_id 
                WHERE user_info.user_email = ? AND issues.returned = 0";
$stmt_books = $dbConn->prepare($query_books);
$stmt_books->bind_param("s", $user_email); 
$stmt_books->execute();
$result_books = $stmt_books->get_result();


// Check for penalties
$query_penalty = "SELECT SUM(penalty_amount) AS penalty 
                  FROM penalties 
                  JOIN user_info ON penalties.user_id = user_info.user_id 
                  WHERE user_info.user_email = ?";
$stmt_penalty = $dbConn->prepare($query_penalty);
$stmt_penalty->bind_param("s", $user_email);
$stmt_penalty->execute();
$result_penalty = $stmt_penalty->get_result();
$penalty = $result_penalty->fetch_assoc()['penalty'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .dashboard { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        .user_header { text-align: center; margin-bottom: 20px; }
        .books-list { margin: 10px 0; }
        button { margin: 5px; }
        .logout { background-color: #f44336; color: white; border: none; padding: 10px 15px; cursor: pointer; }
    </style>
</head>
<body>
<?php include('navbar.php'); ?>

    <div class="dashboard">
        <div class="user_header">
            <h1>Welcome, <?php echo htmlspecialchars($user['user_name']); ?></h1>
            <p>Department: <?php echo htmlspecialchars($user['user_department']); ?></p>
            <p>Program: <?php echo htmlspecialchars($user['user_degree']); ?></p>
        </div>

         <h2>Current Books Issued:</h2>
       <div class="books-list">
            <?php if ($result_books->num_rows > 0): ?>
                <ul>
                    <?php while ($book = $result_books->fetch_assoc()): ?>
                        <li><?php echo htmlspecialchars($book['bookName']); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No books issued currently.</p>
            <?php endif; ?>
        </div> 

         <h2>Penalty:</h2>
        <p><?php echo $penalty > 0 ? "₹" . number_format($penalty, 2) : "No penalty."; ?></p>

        <div>
            <button onclick="window.location.href='borrow_history.php'">View Borrow History</button>
            <button onclick="window.location.href='user_request_bookIssue.html'">Issue a Book</button>
        </div> 

        <div>
            <button class="logout" onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </div>
</body>
</html>
