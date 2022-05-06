<?php
    class Product{
        public $id;
        public $name;
    }

    $products = array();
    $dbc = mysqli_connect('localhost:3306', 'root', 'password', 'users');
    $query = "SELECT id AS id_prod, name AS name_prod FROM products";
    $data = mysqli_query($dbc, $query);
   while($row = mysqli_fetch_assoc($data)){
        $product = new Product();
        $product->id = $row['id_prod'];
        $product->name = $row['name_prod'];
        array_push($products, $product);
   }
   mysqli_close($dbc);
   echo json_encode($products);
?>