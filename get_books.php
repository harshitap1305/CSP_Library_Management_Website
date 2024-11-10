<?php

include('config.php');

if(isset($_POST['searchBook']) && !empty($_POST['searchBook'])){
	$search_query = $_POST['searchBook'];
	if($_POST['searchRadio'] == "bookName"){
	$query = mysqli_query($dbConn,"select * from booklist where UPPER(bookName) LIKE UPPER('%$search_query%')") or die(mysqli_error($dbConn));
	}
    else if($_POST['searchRadio'] == "Author"){
	$query = mysqli_query($dbConn,"select * from booklist where UPPER(authorName) LIKE UPPER('%$search_query%')") or die(mysqli_error($dbConn));
	} 
	else if($_POST['searchRadio'] == "BookCategory"){
		$query = mysqli_query($dbConn,"select * from booklist where UPPER(genre) LIKE UPPER('%$search_query%')") or die(mysqli_error($dbConn));
	}	
	else {
			$query = mysqli_query($dbConn,"select * from booklist where id = '$search_query'") or die(mysqli_error($dbConn));
	}
}
else {
    // If no search term, retrieve all books
    $query = mysqli_query($dbConn, "SELECT * FROM booklist") or die(mysqli_error($dbConn));
}
/*
else if(isset($_POST['searchAuthor']) && !empty($_POST['searchAuthor'])){
    
$search_query = $_POST['searchAuthor'];
$query = mysqli_query($dbConn,"select * from bookdata where UPPER(bAuthor) LIKE UPPER('%$search_query%')") or die(mysqli_error($dbConn));

} else{
    
$search_query = $_POST['searchNo'];
$query = mysqli_query($dbConn,"select * from bookdata where bNo = $search_query") or die(mysqli_error($dbConn));

}  */

/*create table booklist (
id int primary key auto_increment,
bookName varchar(255) NOT NULL,
authorName varchar(255) not null,
genre varchar(255) not null,
shelfNo int not null,
status_book boolean default true,
quantity int default 0,
year_published int,
language varchar(50)
); */

echo "<table border='1' cellpadding='10'>";
echo "<tr>
<th><font color='#3984DB'>BOOK ID</font></th>
<th><font color='#3984DB'>BOOK NAME</font></th>
<th><font color='#3984DB'>AUTHOR</font></th>
<th><font color='#3984DB'>GENRE</font></th>
<th><font color='#3984DB'>SHELF No.</font></th>
<th><font color='#3984DB'>AVALABILITY</font></th>
<th><font color='#3984DB'>QUANTITY</font></th>
<th><font color='#3984DB'>YEAR OF PUBLICATION</font></th>
<th><font color='#3984DB'>LANGUAGE</font></th>
</tr>";

while($row = mysqli_fetch_array( $query ))
{
	
	/*$qty = $row['rqty'];*/

echo "<tr>";
echo '<td>' . $row['id'] . '</td>';
echo '<td>' . $row['bookName'] . '</td>';
echo '<td>' . $row['authorName'] . '</td>';
echo '<td>' . $row['genre'] . '</td>';
echo '<td>' . $row['shelfNo'] . '</td>';
echo '<td>' . $row['status_book'] . '</td>';
echo '<td>' . $row['quantity'] . '</td>';
echo '<td>' . $row['year_published'] . '</td>';
echo '<td>' . $row['language'] . '</td>';

/*
if($qty>0) {
echo '<td>' . $row['status'] . '</td>';
echo '<td><a href="addRequest.php?id=' . $row['bNo'] . '">Request Book</a></td>';
} else{
	echo '<td>' . $row['status'] . '</td>';
	echo '<td>Unable to Request</td>';
}
echo "</tr>";*/

}

echo "</table>";

?>