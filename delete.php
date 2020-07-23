<?php
$id = $_GET['id'];

$db = mysqli_connect('localhost', 'root', '', 'bookly');

$sql = "DELETE FROM books WHERE book_id = $id"; 
mysqli_query($db, $sql);

header('Location: admin.php');
?>