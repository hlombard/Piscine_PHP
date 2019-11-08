<?php


include 'admin_orders_utils_func.php';
include 'admin_utils.php';

session_start();
if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	if (isset($_POST["commandID"]) && $_POST["commandID"] !== "" && is_numeric($_POST["commandID"]) && isset($_POST["command"]) && $_POST["command"] !== "")
	{
		if ($_POST["submit"] === "MODIFIER COMMANDE")
		{
			if (command_id_exists() == true && is_valid_command() == true)
			{
				$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
				if(!$conn){
	  			 die('Could not connect: '.utf8_encode(mysqli_connect_error()));
				}
				$serialized = create_command_serialized();
				$sql = "UPDATE orders SET commande='" . $serialized . "'" . " WHERE id=". $_POST["commandID"] . ";";
				$result = mysqli_query($conn, $sql);
				if (!$result)
					echo "<h1> Echec: Impossible de changer cet ID de commande... désolé !</h1>";
				else
					echo "<h1> La commande ID: " . $_POST['commandID'] . " a bien été modifiée !</h1>";
				mysqli_close($conn);
			}
			else
				echo "<h1> Echec: L'id de commande n'existe pas, ou la nouvelle commande renseigneée n'est pas valide !</h1>";
		}
		else
			echo "<h1> Nothing to be done...</h1>";
	}
	else
	{
		echo "<h1>Impossible de modifier cette commande, mauvais format, ou champs non renseignés...</h1>";
	}
}
else
{
	echo "<h2> Restricted to admins </h2>";
}

Header("refresh:3; url=manage_orders.php");



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
