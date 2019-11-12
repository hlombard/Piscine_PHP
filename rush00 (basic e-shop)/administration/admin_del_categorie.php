<?php

session_start();
include 'admin_utils.php';


if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	if (isset($_POST["categorieID"]) && $_POST["categorieID"] !== "" && isset($_POST["submit"]))
	{
		if ($_POST["submit"] === "SUPPRIMER CATEGORIE")
		{
			if (categorie_alrdy_exists() == true)
				delete_categorie();	
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

function	delete_categorie()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$sql = "DELETE FROM categories WHERE id = '" . $_POST['categorieID'] . "';";
	$result = mysqli_query($conn, $sql);
	if ($result)
		echo "<h1> La categorie ID: " . $_POST['categorieID'] . " a été Supprimée ! </h1>";
	else
		echo "<h1> Error impossible de supprimer la catégorie ! </h1>";
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