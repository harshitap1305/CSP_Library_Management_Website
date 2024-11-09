<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $description = $_POST['description'];

    $query = "INSERT INTO books (title, author, genre, description, availability) VALUES (?, ?, ?, ?, 1)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title, $author, $genre, $description]);

    echo "Book added successfully!";
}
?>
