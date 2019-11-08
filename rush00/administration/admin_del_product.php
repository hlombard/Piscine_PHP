<?php

session_start();
include 'admin_utils.php';

if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	if (isset($_POST["id"]) && $_POST["id"] !== "" && is_numeric($_POST["id"]))
	{
		if ($_POST["submit"] === "SUPPRIMER PRODUIT")
		{
			if (product_id_exists() == true)
			{
				$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
				if(!$conn){
			   	die('Could not connect: '.utf8_encode(mysqli_connect_error()));
				}
				$sql = "DELETE FROM products WHERE id=" . $_POST["id"] . ";";
				$ret = mysqli_query($conn, $sql);
				if (!$ret)
				{
			   		echo "<h1>Impossible de supprimer cet ID de produit...</h1>";
				}
				else
				{
					echo "<h1> Le produit ID: " . $_POST["id"] . " a été supprimé !</h1>";
				}
				mysqli_close($conn);
			}
			else
				echo "<h1>Impossible de supprimer cet ID de produit, existe t-il vraiment... ?</h1>";
		}
	}
	else
	{
		echo "<h1>Impossible de supprimer ce produit, mauvais format, ou champ non renseigné...</h1>";
	}
}
else
{
	echo "<h2> Restricted to admins </h2>";
}

Header("refresh:4; url=manage_products.php");

function	product_id_exists()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$_POST['id'] = mysqli_real_escape_string($conn, $_POST['id']);
	$sql = "SELECT * FROM products WHERE id=" .$_POST["id"] . ";";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if (!$row)
		return (false);
	else
		return (true);
}

?>
