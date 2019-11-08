<?php

session_start();
include 'admin_utils.php';

if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	if (everything_is_set() == true && product_exists() == false)
	{
		if (add_product())
			echo "<h1> Produit ajouté ! </h1>";
		if (isset($_POST['catID']) && $_POST['catID'] && is_numeric($_POST['catID']))
		{	
			if (categorie_id_exists($_POST['catID']) == true)
			{
				add_categorie_link_db($_POST['catID']);
			}
		}
	}	
	else
	{
		echo "<h1> Echec: Tous les champs doivent etre renseigner, ou le nom de produit existe deja...</h1>";
	}
}
else
{
	echo "<h2> Restricted to admins </h2>";
}

header("refresh:3; url=manage_products.php");

function	categorie_id_exists($id)
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$id = mysqli_real_escape_string($conn, $id);
	$sql = "SELECT * FROM categories WHERE id=" .$id . ";";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if (!$row)
		return (false);
	else
		return (true);
}

function	get_current_product_id()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$sql = "SELECT products.id FROM products WHERE name='" .$_POST['name'] . "';";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	return ($row[0]);
}

function	add_categorie_link_db($id)
{
	$id_product = get_current_product_id();
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$sql = "INSERT INTO link (id_product, id_category) VALUES (" . $id_product . ", " . $id . ");";
	$result = mysqli_query($conn, $sql);
	if ($result)
		echo "<h2> La catégorie du produit a bien été ajoutée ! </h2>";
}

function	add_product()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$_POST['url'] = mysqli_real_escape_string($conn, $_POST['url']);
	$_POST['prix'] = mysqli_real_escape_string($conn, $_POST['prix']);
	$_POST['stock'] = mysqli_real_escape_string($conn, $_POST['stock']);
	$sql = "INSERT INTO products (name, img, price, stock) VALUES ('" . $_POST['name'] . "', '" . $_POST['url'] . "', " . $_POST['prix'] . ", " . $_POST['stock'] . ");";
	$result = mysqli_query($conn, $sql);
	mysqli_close($conn);
	if ($result)
		return (true);
	else
		return (false);
}


function product_exists()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$_POST['name'] = mysqli_real_escape_string($conn, $_POST['name']);
	$sql = "SELECT * FROM products WHERE name=" .$_POST["name"] . ";";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if (!$row)
		return (false);
	else
		return (true);
}

function everything_is_set()
{
	if (isset($_POST['name']) && $_POST['name'] !== "" && isset($_POST['prix']) && $_POST['prix'] !== "" )
	{
		if (isset($_POST['stock']) && $_POST['stock'] && isset($_POST['url']) && $_POST['url'])
		{
			if (isset($_POST['submit']) && $_POST['submit'] === "CREER PRODUIT")
				return (true);
		}
	}
	return (false);
}

?>
