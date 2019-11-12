<?php

session_start();
include 'admin_utils.php';


if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	if (isset($_POST["name"]) && $_POST["name"] !== "" && isset($_POST["submit"]))
	{
		if ($_POST["submit"] === "CREER CATEGORIE")
		{
			if (strlen($_POST["name"]) > 30)
			{
				echo "<h1> Echec: Max 30 charactères pour un nom de catégorie ! </h1>";
				header("refresh:3; url=manage_categories.php");
			}	
			if (categorie_alrdy_exists() == true)
				echo "<h1> Echec: Cette Catégorie existe déjà ! </h1>";
			else
			{
				add_categorie_to_db();
			}
			header("refresh:3; url=manage_categories.php");
		}
	}
	else
	{
		echo "<h1> Echec: Tous les champs doivent etre renseigner...</h1>";
		header("refresh:3; url=manage_categories.php");
	}
}
else
{
	echo "<h2> Restricted to admins </h2>";
	header("refresh:3; url=manage_categories.php");
}

function	add_categorie_to_db()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$sql = "INSERT INTO categories (nom) VALUES ('" . $_POST['name'] . "');";
	$result = mysqli_query($conn, $sql);
	if ($result)
		echo "<h1> La categorie " . $_POST['name'] . " a été ajoutée ! </h1>";
	else
		echo "<h1> Error impossible d'ajouter la catégorie ! </h1>";
	mysqli_close($conn);
}

function	categorie_alrdy_exists()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$_POST['name'] = mysqli_real_escape_string($conn, $_POST['name']);
	$sql = "SELECT nom FROM categories WHERE nom='" .$_POST['name'] . "';";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if ($row[0])
		return (true);
	else
		return (false);
}

?>