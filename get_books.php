<?php
include 'config.php';

$query = "SELECT * FROM books";
$stmt = $pdo->query($query);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($books); 
?>
