<?php
include('config.php');

if(isset($_POST['searchBook']) && !empty($_POST['searchBook'])){
    $search_query = $_POST['searchBook'];
    if($_POST['searchRadio'] == "bookName"){
        $query = mysqli_query($dbConn,"SELECT * FROM booklist WHERE UPPER(bookName) LIKE UPPER('%$search_query%')") or die(mysqli_error($dbConn));
    }
    else if($_POST['searchRadio'] == "Author"){
        $query = mysqli_query($dbConn,"SELECT * FROM booklist WHERE UPPER(authorName) LIKE UPPER('%$search_query%')") or die(mysqli_error($dbConn));
    } 
    else if($_POST['searchRadio'] == "BookCategory"){
        $query = mysqli_query($dbConn,"SELECT * FROM booklist WHERE UPPER(genre) LIKE UPPER('%$search_query%')") or die(mysqli_error($dbConn));
    }   
    else {
        $query = mysqli_query($dbConn,"SELECT * FROM booklist WHERE id = '$search_query'") or die(mysqli_error($dbConn));
    }
}
else {
    $query = mysqli_query($dbConn, "SELECT * FROM booklist") or die(mysqli_error($dbConn));
}

echo "<table border='1' cellpadding='10'>";
echo "<tr>
<th><font color='#3984DB'>BOOK ID</font></th>
<th><font color='#3984DB'>BOOK NAME</font></th>
<th><font color='#3984DB'>AUTHOR</font></th>
<th><font color='#3984DB'>CATEGORY</font></th>
<th><font color='#3984DB'>SHELF No.</font></th>
<th><font color='#3984DB'>AVAILABILITY</font></th>
<th><font color='#3984DB'>QUANTITY</font></th>
<th><font color='#3984DB'>YEAR OF PUBLICATION</font></th>
<th><font color='#3984DB'>LANGUAGE</font></th>
<th><font color='#3984DB'>REQUEST</font></th>
</tr>";

while($row = mysqli_fetch_array($query))
{
    echo "<tr>";
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['bookName'] . '</td>';
    echo '<td>' . $row['authorName'] . '</td>';
    echo '<td>' . $row['genre'] . '</td>';
    echo '<td>' . $row['shelfNo'] . '</td>';
    echo '<td>' . ($row['status_book'] ? 'Available' : 'Not Available') . '</td>';
    echo '<td>' . $row['quantity'] . '</td>';
    echo '<td>' . $row['year_published'] . '</td>';
    echo '<td>' . $row['language'] . '</td>';

    if ($row['remain'] && $row['quantity'] > 0) {
        echo '<td><a href="requestBook.php?id=' . $row['id'] . '">Request Book</a></td>';
    } else {
        echo '<td>Not Available</td>';
    }

    echo "</tr>";
}
echo "</table>";
?>
