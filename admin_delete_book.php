<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];

    $query = "DELETE FROM books WHERE book_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$book_id]);

    echo "Book deleted successfully!";
}
?>
