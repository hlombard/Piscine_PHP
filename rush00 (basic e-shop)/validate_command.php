<?php

session_start();

function	verify_command_validity()
{
	if (isset($_SESSION["buy"]) && $_SESSION["buy"])
	{
		$valid = 1;
		$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
		if(!$conn)
			die('Could not connect: '.utf8_encode(mysqli_connect_error()));
		foreach($_SESSION["buy"] as $product => $quantity)
		{
			$product = mysqli_real_escape_string($conn, $product);
			$sql = "SELECT stock FROM products WHERE name = \"$product\";";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);
			if ($row[0] < $quantity)
				$valid = 0;
		}
		mysqli_close($conn);
		return ($valid);
	}
	return (0);
}

function	update_database()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn)
		die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	foreach($_SESSION["buy"] as $product => $quantity)
	{
		$product = mysqli_real_escape_string($conn, $product);
		$quantity = mysqli_real_escape_string($conn, $quantity);
		$sql = "UPDATE products SET stock = stock - $quantity WHERE name='$product';";
		mysqli_query($conn, $sql);
	}
	mysqli_close($conn);
}

if (isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] !== "" && isset($_SESSION["buy"]) && $_SESSION["buy"]
&& isset($_SESSION["shopping cart"]) && $_SESSION["shopping cart"])
{
	if (verify_command_validity() == 1)
	{
		update_database();
		add_to_orders_db();
		unset($_SESSION["shopping cart"]);
		unset($_SESSION["buy"]);
		echo "<h1> La commande a bien eté effectuée ! Merci </h1>";
	}
	else
	{
		echo "<h1> Echec: La commande n'est pas valide ! </h1>";
		unset($_SESSION["shopping cart"]);
	}
}
Header("refresh:3; url=index.php");

function add_to_orders_db()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
   if(!$conn){
      die('Could not connect: '.utf8_encode(mysqli_connect_error()));
   }
   $serialized = serialize($_SESSION["buy"]);
	$_SESSION["loggued_on_user"] = mysqli_real_escape_string($conn, $_SESSION["loggued_on_user"]);
   $sql = "INSERT INTO orders(login,commande) VALUES('".$_SESSION["loggued_on_user"]."','".$serialized."')";
   if(!mysqli_query($conn, $sql))
   {
	   echo "<h2> Command Error </h2>";
   }
   mysqli_close($conn);
}


?>
