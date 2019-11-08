<?php

session_start();
include 'admin_utils.php';


if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	if (isset($_POST["name"]) && $_POST["name"] !== "" && isset($_POST["categorieID"]) && $_POST["categorieID"] !== "" && isset($_POST["submit"]))
	{
		if ($_POST["submit"] === "MODIFIER CATEGORIE")
		{
			if (strlen($_POST["name"]) > 30)
			{
				echo "<h1> Echec: Max 30 charactères pour un nom de catégorie ! </h1>";
				header("refresh:3; url=manage_categories.php");
			}	
			if (categorie_alrdy_exists() == true)
				modify_categorie();	
			else
				echo "<h1> Echec: Cet ID de Catégorie n'existe pas ! </h1>";
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

function	modify_categorie()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$_POST['name'] = mysqli_real_escape_string($conn, $_POST['name']);
	$sql = "UPDATE categories SET nom = '" . $_POST['name'] . "' WHERE id=" . $_POST['categorieID'] . ";";
	$result = mysqli_query($conn, $sql);
	if ($result)
		echo "<h1> La categorie ID: " . $_POST['categorieID'] . " a été modifiée! </h1>";
	else
		echo "<h1> Error impossible de modifier la catégorie ! </h1>";
	mysqli_close($conn);
}

function	categorie_alrdy_exists()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$_POST['categorieID'] = mysqli_real_escape_string($conn, $_POST['categorieID']);
	$sql = "SELECT nom FROM categories WHERE id='" .$_POST['categorieID'] . "';";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if ($row[0])
		return (true);
	else
		return (false);
}

?>