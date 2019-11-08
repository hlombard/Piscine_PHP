<?php
session_start();

function show_shopping_cart_content()
{
	if (isset($_SESSION["shopping cart"]))
	{
		$array = array();
		for($i = 0; $i < count($_SESSION["shopping cart"]); $i++)
		{
			foreach($_SESSION["shopping cart"][$i] as $key => $elem)
			{
				$array[$key] = $elem;
			}
		}
		return ($array);
	}

	return (NULL);
}

function	create_table($array)
{
	$total_price = 0;
	$total_quantity = 0;
	echo "<table> ";
	echo "<tr> <th> Produit </th> <th> Quantité </th> <th> Prix </th> </tr>";
	foreach($array as $product => $quantity)
	{
		echo "<tr>";
		echo "<td>" . $product . "</td>";
		echo "<td>" . $quantity . "</td>";
		$price = query_price_for_quantity($product, $quantity);
		$total_price += $price;
		$total_quantity += $quantity;
		echo "<td>" . $price . " €" . "</td>";
		echo "</tr>";
	}
		echo "<tr>";
		echo "<td class=\"total\">" . "TOTAL" . "</td>";
		echo "<td class=\"total\">" . $total_quantity . "</td>";
		echo "<td class=\"total\">" . $total_price . " €" . "</td>";
		echo "</tr>";
		echo "</table>";

		$_SESSION["buy"] = $array;
		show_options();
}

function	show_options()
{
	if (isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] !== "")
	{
		echo "<form action=\"validate_command.php\" method=\"post\">";
		echo "<input type=\"submit\" value=\"Je VALIDE ma commande\">";
		echo "</form>";
	}
	else
	{
		echo "<b> Vous devez avoir ";
		echo "<a href=\"register.html\">créer un compte</a> ";
		echo "et ";
		echo "<a href=\"login.html\">vous connecter</a>";
		echo " pour valider votre commande </b>";
	}
	echo "<br \> <br \>";
	echo "<form action=\"my_shopping_cart.php?empty=true\" method=\"post\">";
		echo "<input type=\"submit\" value=\"Vider mon panier\">";
		echo "</form>";
}

function	query_price_for_quantity($product, $quantity)
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$product = mysqli_real_escape_string($conn, $product);
	$sql = "SELECT price FROM products WHERE name = \"$product\";";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	return ($row[0] * $quantity);
}

function empty_shopping_cart_if_needed()
{
	if (isset($_GET["empty"]) && $_GET["empty"] === "true")
	{
		unset($_SESSION["shopping cart"]);
		unset($_SESSION["buy"]);
	}
}

?>

<html>
		<meta charset="UTF-8">
		<head> <link rel="stylesheet" type="text/css" href="shopping_cart.css"> </head>
	<body>
		<h1> Mon Panier: </h1>
		<?php empty_shopping_cart_if_needed();
			$array = show_shopping_cart_content();
		if ($array !== NULL)
			create_table($array);
		else
			echo "Votre panier est actuellement vide...";
		echo "<br \> <br \>";
		echo "<form action=\"index.php\" method=\"post\">";
		echo "<input type=\"submit\" value=\"Revenir à la boutique\">";
		echo "</form>";
		?>
	</body>
</html>
