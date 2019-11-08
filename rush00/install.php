<html>
   <head>
      <meta charset="UTF-8">
      <title>Connecting MySQLi Server</title>
   </head>

   <body>
      <?php
        create_db();
        create_table_products();
        create_table_admin();
        create_table_categories();
		create_table_orders();
		create_table_link();
        Header("refresh:5; url=index.php");
      ?>
   </body>
</html>


<?php


function create_db()
{
         $conn = mysqli_connect('localhost', 'root', 'rootroot');
         if(! $conn )
            echo 'Connected failure<br>';
         $sql = "CREATE DATABASE rush00";
         if (mysqli_query($conn, $sql)) {
            echo "Database created successfully";
         } else {
            echo "<meta charset=\"UTF-8\">";
            echo "Error creating database: " . utf8_encode(mysqli_error($conn));
         }
		 mysqli_close($conn);
		echo "<br \>";
}

function create_table_products()
{
         $conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
         if(!$conn)
            die('Could not connect: '.utf8_encode(mysqli_connect_error()));

         $sql = "CREATE TABLE products(
            id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
            name VARCHAR(25) NOT NULL,
            img VARCHAR(255) NOT NULL,
            price INT NOT NULL,
            stock INT NOT NULL)";

         if(mysqli_query($conn, $sql)){
         echo "Table created successfully";
         } else {
            echo "Table is not created successfully ";
         }
         fill_table_products();
		 mysqli_close($conn);
		echo "<br \>";
}

function fill_table_products()
{
   $conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
   if(!$conn){
      die('Could not connect: '.utf8_encode(mysqli_connect_error()));
   }

   $sql = "INSERT INTO products (name, img, price, stock)
   VALUES
   ('Pantalon Noir', 'https://www.epi-haute-visibilite.com/1396-cart_default/pantalon-de-travail-slim-blaklader-noir-service-145198459900.jpg', 30, '3'),
   ('Pantalon Rouge', 'https://img2.tennis-point.com/out/pictures/generated/product/1/64_64_80/05644002950000_1.jpg', 30, '3'),
   ('T-Shirt Noir', 'https://cdn.webshopapp.com/shops/31218/files/62757832/45x45x2/blaklader-blaklaeder-t-shirt-protection-uv-noir-33.jpg', 25, '3'),
   ('T-Shirt Rouge', 'https://p-wearshop.com/WebRoot/LaPoste/Shops/box82388-170130/5B36/2F44/AC37/CBE9/D927/0A0C/05BC/8802/T-shirt_rouge_col_V_arriere_xs.png', 25, '3'),
   ('Short Noir', 'https://www.epi-haute-visibilite.com/1170-cart_default/short-de-travail-x1500-noir-blaklader-150213109900.jpg', 20, '3'),
   ('Short Rouge', 'https://img2.tennis-point.com/out/pictures/generated/product/1/64_64_80/00443543736000_1.jpg', 20, '3'),
   ('Sweat Noir', 'http://rccreations.fr/WebRoot/Store20/Shops/aafc4abf-5474-4bed-aa61-01c62ea13fff/545B/318E/8F20/E6CA/8FBA/0A48/354B/5765/308260111407_xs.jpeg', 42, '3'),
   ('Sweat Rouge', 'https://p-wearshop.com/WebRoot/LaPoste/Shops/box82388-170130/5BDC/277A/8BE3/AFC5/4235/0A0C/05BB/685C/Sweat_Rouge_Never_Give_Up_xs.jpg', 42, '3')
   ";

   if(mysqli_query($conn, $sql)){
   echo "Table content created successfully";
   } else {
      echo "Table content wasn't created successfully ";
   }
   mysqli_close($conn);
	echo "<br \>";
}

function create_table_admin()
{
   $conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
   if(!$conn)
      die('Could not connect: '.utf8_encode(mysqli_connect_error()));

   $sql = "CREATE TABLE admin
   (id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
      login VARCHAR(25) NOT NULL);";

   if(mysqli_query($conn, $sql)){
   echo "Table created successfully";
   } else {
      echo "Table is not created successfully ";
   }
   fill_table_admin();
   mysqli_close($conn);
	echo "<br \>";
}

function fill_table_admin()
{
   $conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
   if(!$conn){
      die('Could not connect: '.utf8_encode(mysqli_connect_error()));
   }

   $sql = "INSERT INTO admin (login)
   VALUES ('admin');";

   if(mysqli_query($conn, $sql)){
   echo "Admin content added successfully";
   } else {
      echo "Admin content wasn't filled successfully ";
   }
   mysqli_close($conn);
	echo "<br \>";
}

function create_table_categories()
{
   $conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
   if(!$conn)
      die('Could not connect: '.utf8_encode(mysqli_connect_error()));

   $sql = "CREATE TABLE categories
   (id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
      nom VARCHAR(30) NOT NULL);";

   if(mysqli_query($conn, $sql)){
   echo "Table categories created successfully";
   } else {
      echo "Table categories is not created successfully ";
   }
   fill_table_categories();
   mysqli_close($conn);
	echo "<br \>";
}

function fill_table_categories()
{
   $conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
   if(!$conn){
      die('Could not connect: '.utf8_encode(mysqli_connect_error()));
   }

   $sql = "INSERT INTO categories (nom)
   VALUES ('t-shirt'), ('sweat'), ('pantalon'), ('short'), ('été'), ('hiver');";

   if(mysqli_query($conn, $sql)){
   echo "Categories content added successfully";
   } else {
      echo "Categories content wasn't filled successfully ";
   }
   mysqli_close($conn);
	echo "<br \>";
}

function create_table_orders()
{
   $conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
   if(!$conn)
      die('Could not connect: '.utf8_encode(mysqli_connect_error()));

   $sql = "CREATE TABLE orders
   (id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   login VARCHAR(30) NOT NULL,
   commande VARCHAR(5000) NOT NULL);";

   if(mysqli_query($conn, $sql)){
   echo "Table Orders created successfully";
   } else {
      echo "Table Orders is not created successfully ";
   }
   mysqli_close($conn);
	echo "<br \>";
}

function	create_table_link()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
   if(!$conn)
      die('Could not connect: '.utf8_encode(mysqli_connect_error()));

   $sql = "CREATE TABLE link
   (id_product INT NOT NULL,
   id_category INT NOT NULL);";

   if(mysqli_query($conn, $sql)){
   echo "Table Link created successfully";
   } else {
      echo "Table Link is not created successfully ";
   }
   mysqli_close($conn);
   fill_table_link();
	echo "<br \>";
}

function	fill_table_link()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
   if(!$conn){
      die('Could not connect: '.utf8_encode(mysqli_connect_error()));
   }
   $sql = "INSERT INTO link (id_product, id_category)
   VALUES (1, 3), (1, 6), (2, 3), (2, 6), (3, 1), (3, 5), (4, 1), (4, 5), (5, 4), (5, 5), (6, 4), (6, 5), (7, 2), (7, 6), (8, 2), (8, 6);";
   if(mysqli_query($conn, $sql)){
   echo "Link content added successfully";
   } else {
      echo "Link content wasn't filled successfully ";
   }
   mysqli_close($conn);
	echo "<br \>";
}

      ?>
