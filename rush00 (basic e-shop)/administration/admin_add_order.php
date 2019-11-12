<?php

include 'admin_orders_utils_func.php';
include 'admin_utils.php';

session_start();
if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	if (isset($_POST["command"]) && $_POST["command"] !== "" && isset($_POST["login"]) && $_POST["login"] !== "")
	{
		if ($_POST["submit"] === "CREER COMMANDE")
		{
			if (is_valid_command() == true)
			{
				$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
				if(!$conn){
	  			 die('Could not connect: '.utf8_encode(mysqli_connect_error()));
				}
				$serialized = create_command_serialized();
				$sql = "INSERT INTO orders (login, commande) VALUES ('" . $_POST["login"] . "', '" . $serialized . "');";
				$result = mysqli_query($conn, $sql);
				if (!$result)
					echo "<h1> Echec: Impossible de créer cette commande... désolé !</h1>";
				else
					echo "<h1> La commande a bien été créée !</h1>";
				update_stock($conn, $serialized);
				mysqli_close($conn);
				Header("refresh:3; url=manage_orders.php");
			}
			else
			{
				echo "<h1> Echec: La nouvelle commande renseigneée n'est pas valide ou manque de stock pour y repondre!</h1>";
				Header("refresh:3; url=manage_orders.php");
			}
		}
		else
			echo "<h1> Nothing to be done...</h1>";
	}
	else
	{
		echo "<h1>Impossible de créer cette commande, mauvais format, ou champs non renseignés...</h1>";
		Header("refresh:3; url=manage_orders.php");
	}
}
else
{
	echo "<h2> Restricted to admins </h2>";
	Header("refresh:3; url=../index.php");
}

function	update_stock($conn, $serialized)
{
	$array = unserialize($serialized);
	foreach($array as $key => $elem)
	{
		$sql = "UPDATE products SET stock = stock - $elem WHERE name='$key';";
		$result = mysqli_query($conn, $sql);
	}
}