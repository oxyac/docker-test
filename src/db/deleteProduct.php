<?php
$idFromGet = $_GET['id'];

    $dbc = mysqli_connect('localhost:3306', 'root', 'password', 'users');
    $query = "DELETE FROM products WHERE products.id=$idFromGet";
    $data = mysqli_query($dbc, $query);
   mysqli_close($dbc);
?>