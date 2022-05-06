<?php
$name = $_POST['name'];
    $dbc = mysqli_connect('localhost:3306', 'root', '', 'users');
    $query = "INSERT INTO products (name) VALUES('$name')";
    $data = mysqli_query($dbc, $query);
   mysqli_close($dbc);
?>