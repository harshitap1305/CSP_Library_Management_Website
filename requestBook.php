<?php
session_start();
include('config.php');
if (!isset($_SESSION['user_id'])) {
    die("User not logged in. Please log in to request a book.");
}
$user_id = $_SESSION['user_id'];

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $book_id = intval($_GET['id']); 
    
    $query = mysqli_query($dbConn, "SELECT * FROM booklist WHERE id = $book_id AND remain > 0");
    if (mysqli_num_rows($query) > 0) {
        
        $book = mysqli_fetch_assoc($query);

       
        $check_request = mysqli_query($dbConn, "SELECT * FROM requests WHERE book_id = $book_id AND user_id = $user_id AND status = 'Pending'");
        if (mysqli_num_rows($check_request) > 0) {
            echo "You have already requested this book, and the request is pending.";
        } else {
            
            $insert_request = mysqli_query($dbConn, "INSERT INTO requests (book_id, user_id) VALUES ($book_id, $user_id)");
            if ($insert_request) {
                
                mysqli_query($dbConn, "UPDATE booklist SET remain = remain - 1 WHERE id = $book_id");
                echo "Your request for the book '{$book['bookName']}' has been submitted successfully.";
                echo "<a href='booklist.php'>Go back to Booklist</a>";
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
