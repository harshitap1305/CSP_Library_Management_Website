<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $availability = $_POST['availability'] ? 1 : 0;

    $query = "UPDATE books SET title = ?, author = ?, genre = ?, availability = ? WHERE book_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title, $author, $genre, $availability, $book_id]);

    echo "Book updated successfully!";
}
?>
