<?php
    class Product{
        public $id;
        public $name;
    }
    $products = array();

$servername = "users-mysql";
$username = "og";
$password = "password";
$dbname = "users";
$port = "3306";

//$dbc = mysqli_connect('users_mysql:3306', 'og', 'password', 'users');
//die;
    $dbh = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
//    die;
    $query = "SELECT id AS id_prod, name AS name_prod FROM products";
    $data = $dbh->query($query);
   while($row = mysqli_fetch_assoc($data)){
        $product = new Product();
        $product->id = $row['id_prod'];
        $product->name = $row['name_prod'];
        array_push($products, $product);
   }
   $dbh = null;
   echo json_encode($products);
?>