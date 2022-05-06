<?php
$name = $_POST['name'];
$id = $_POST['id'];

    $dbc = mysqli_connect('localhost:3306', 'root', '', 'users');
    $query = "UPDATE products SET name='$name' WHERE products.id=$id";
    $data = mysqli_query($dbc, $query);
   mysqli_close($dbc);
?>