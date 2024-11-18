<?php
session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    die("User not logged in. Please log in to request a book.");
}

$user_email = $_SESSION['user'];

// Retrieve the user ID based on the logged-in user's email
$user_query = mysqli_query($dbConn, "SELECT user_id FROM user_info WHERE user_email = '$user_email'");
if (mysqli_num_rows($user_query) == 0) {
    die("User not found. Please contact the administrator.");
}

$user = mysqli_fetch_assoc($user_query);
$user_id = $user['user_id']; // Now the user_id is properly defined

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $book_id = intval($_GET['id']);
    
    // Check if the book exists and is available
    $query = mysqli_query($dbConn, "SELECT * FROM booklist WHERE id = $book_id AND remain > 0");
    if (mysqli_num_rows($query) > 0) {
        $book = mysqli_fetch_assoc($query);

        // Check if the user has already requested the book
        $check_request = mysqli_query($dbConn, "SELECT * FROM requests WHERE book_id = $book_id AND user_id = $user_id AND status = 'Pending'");
        if (mysqli_num_rows($check_request) > 0) {
            echo "You have already requested this book, and the request is pending.";
        } else {
            // Insert the book request
            $insert_request = mysqli_query($dbConn, "INSERT INTO requests (book_id, user_id) VALUES ($book_id, $user_id)");
            if ($insert_request) {
                // Update the book's remaining quantity
                mysqli_query($dbConn, "UPDATE booklist SET remain = remain - 1 WHERE id = $book_id");
                echo "Your request for the book '{$book['bookName']}' has been submitted successfully.";
                echo "<a href='user_request_bookIssue.html'> Request another book</a>";
            } else {
                echo "Error while submitting your request. Please try again later.";
            }
        }
    } else {
        echo "This book is not available or does not exist.";
    }
} else {
    echo "Invalid book ID.";
}
?>
