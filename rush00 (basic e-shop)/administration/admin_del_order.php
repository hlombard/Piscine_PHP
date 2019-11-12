<?php

session_start();
include 'admin_utils.php';

if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	if (isset($_POST["commandID"]) && $_POST["commandID"] !== "" && is_numeric($_POST["commandID"]))
	{
		if ($_POST["submit"] === "SUPPRIMER COMMANDE")
		{
			if (command_id_exists() == true)
			{
				$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
				if(!$conn){
			   	die('Could not connect: '.utf8_encode(mysqli_connect_error()));
				}
				$sql = "DELETE FROM orders WHERE id=" . $_POST["commandID"] . ";";
				$ret = mysqli_query($conn, $sql);
				if (!$ret)
				{
			   		echo "<h1>Impossible de supprimer cet ID de commande...</h1>";
				}
				else
				{
					echo "<h1> La commande ID: " . $_POST["commandID"] . " a été supprimée !</h1>";
				}
				mysqli_close($conn);
			}
			else
				echo "<h1>Impossible de supprimer cet ID de commande, existe t-il vraiment... ?</h1>";
		}
	}
	else
	{
		echo "<h1>Impossible de supprimer cette commande, mauvais format, ou champs non renseignés...</h1>";
	}
}
else
{
	echo "<h2> Restricted to admins </h2>";
}

Header("refresh:4; url=manage_orders.php");

function	command_id_exists()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$_POST['commandID'] = mysqli_real_escape_string($conn, $_POST['commandID']);
	$sql = "SELECT * FROM orders WHERE id=" .$_POST["commandID"] . ";";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if (!$row)
		return (false);
	else
		return (true);
}

?>
