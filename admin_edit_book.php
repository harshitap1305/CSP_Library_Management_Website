<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

include 'config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $sBookTitle = $_POST['book_title'];
    $sAuthor = $_POST['author'];
    $sIsbn = $_POST['isbn'];
    $sPublisher = $_POST['publisher'];

   
    if (!$dbConn) {
        die("Connection failed: " . mysqli_connect_error());
    }

   
    $sSql = "INSERT INTO books (book_title, author, isbn, publisher) VALUES (?, ?, ?, ?)";
    $stmt = $dbConn->prepare($sSql);

    if ($stmt) {
       
        $stmt->bind_param('ssss', $sBookTitle, $sAuthor, $sIsbn, $sPublisher);

       
        if ($stmt->execute()) {
            echo "New book added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }


        $stmt->close();
    } else {
        echo "Error preparing the query: " . $dbConn->error;
    }

   
    $dbConn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Books</title>
</head>
<body>
    <h1>Edit Books</h1>
    <form method="post">
        <select name="book_id">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['title']; ?>
                </option>
            <?php } ?>
        </select><br>
        <input type="text" name="title" placeholder="Title"><br>
        <input type="text" name="author" placeholder="Author"><br>
        <input type="number" name="quantity" placeholder="Quantity"><br>
        <button type="submit">Update Book</button>
    </form>
</body>
</html>
