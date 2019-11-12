<?php

session_start();
include 'admin_utils.php';

if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	if (everything_is_set() == true && product_id_exists() == true)
	{
		if (modify_product())
			echo "<h1> Produit modifié! </h1>";
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
		echo "<h1> Echec: Tous les champs doivent etre renseigner, ou l'ID de produit n'existe pas..</h1>";
	}
}
else
{
	echo "<h2> Restricted to admins </h2>";
}

header("refresh:3; url=manage_products.php");

function	product_id_exists()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$_POST['prodID'] = mysqli_real_escape_string($conn, $_POST['prodID']);
	$sql = "SELECT * FROM products WHERE id=" .$_POST['prodID'] . ";";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if (!$row)
		return (false);
	else
		return (true);
}

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


function	add_categorie_link_db($id)
{
	$id_product = $_POST['prodID'];
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$id = mysqli_real_escape_string($conn, $id);
	$sql = "INSERT INTO link (id_product, id_category) VALUES (" . $id_product . ", " . $id . ");";
	$result = mysqli_query($conn, $sql);
	if ($result)
		echo "<h2> La catégorie du produit a bien été modifiée! </h2>";
}

function	modify_product()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$_POST['name'] = mysqli_real_escape_string($conn, $_POST['name']);
	$_POST['url'] = mysqli_real_escape_string($conn, $_POST['url']);
	$_POST['prix'] = mysqli_real_escape_string($conn, $_POST['prix']);
	$_POST['stock'] = mysqli_real_escape_string($conn, $_POST['stock']);
	$sql = "UPDATE products SET name = " . "'" . $_POST['name'] . "', img = '" . $_POST['url'] . "', price = " . $_POST['prix'] . ", stock = " . $_POST['stock'] . " WHERE id = " .$_POST['prodID'] . ";";
	$result = mysqli_query($conn, $sql);
	mysqli_close($conn);
	if ($result)
		return (true);
	else
		return (false);
}


function everything_is_set()
{
	if (isset($_POST['name']) && $_POST['name'] !== "" && isset($_POST['prix']) && $_POST['prix'] !== "" )
	{
		if (isset($_POST['stock']) && $_POST['stock'] && isset($_POST['url']) && $_POST['url'])
		{
			if (isset($_POST['submit']) && $_POST['submit'] === "MODIFIER PRODUIT")
				return (true);
		}
	}
	return (false);
}

?>
