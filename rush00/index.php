<?php
session_start();
-include 'administration/admin_utils.php';


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

function	header_menu()
{
	echo("<div class=\"menu\">");
	if (isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] !== "")
	{
		echo "<span> Bonjour " . $_SESSION["loggued_on_user"] . " ! </span>";
		echo("<a href=\"logout.php\"> Se déconnecter </a>");
		echo("<a href=\"modify_pw.html\"> Modifier son mdp </a>");
		echo("<a href=\"del_account.php\" onclick=\"return confirm('Êtes vous sur de vouloir supprimer votre compte?')\"> Supprimer mon compte </a>");
		if (current_user_is_admin() == true)
		{
			echo("<a class=\"admin\" href=\"admin.php\"> Espace Admin </a>");
		}

	}
	else
	{
		echo("<a href=\"login.html\"> Se connecter </a>");
		echo("<a href=\"register.html\"> Créer un compte </a>");
	}
	$array = show_shopping_cart_content();
	set_shopping_cart_quick_view($array);
	echo("</div>");
}

function	set_shopping_cart_quick_view($array)
{
	echo "<a class=\"shopping_cart\" href=\"my_shopping_cart.php\"> Mon Panier (";
	if ($array === NULL)
		echo "0 Article, 0€)";
	else
	{
		$total_products = 0;
		$total_price = 0;
		foreach($array as $product => $quantity)
		{
			$total_products += $quantity;
			$total_price += query_price_for_quantity($product, $quantity);
		}
		echo $total_products . " Articles, ";
		echo $total_price . "€)";
	}
	echo "</a>";
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

function	show_content()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$_POST['categorie'] = mysqli_real_escape_string($conn, $_POST['categorie']);
	if (isset($_POST["submit"]) && isset($_POST["categorie"]) && $_POST["submit"] === "TRIER")
		$sql = "SELECT products.id, products.name, products.img, products.price, products.stock FROM products LEFT JOIN link ON products.id = link.id_product WHERE link.id_category = " . $_POST['categorie'] . ";";
	else
		$sql = "SELECT * from products";
	$result = mysqli_query($conn, $sql);
	display_shop($result);
	mysqli_close($conn);
}

function	display_shop($result)
{
	echo "<div class=\"shop\">";
	while($row = mysqli_fetch_array($result))
	{
		if ($row["stock"] > 0)
			display_product($row);
	}
	echo "</div>";

}

function	display_product($row)
{
	echo "<div>";
	echo "<h4> " . $row["name"] . "</h4>";
	echo "<img src=" . $row["img"] . ">";
	echo "<br \>";
	echo "<span id=\"price\"> Prix: " . $row["price"] . "€" . "</span>";
	echo "<br \>";
	echo "<i id=\"stock\"> En Stock: " .$row["stock"] . " restant(s)" . "</i>";


	echo "<form method=\"post\" action=\"\">";

	echo "<select name=command>";
	echo "<option value=\"" . 0 . "\"" . "disabled selected=\"selected\">" . 0 . "</option>";
	for($i = 1; $i < $row["stock"] + 1; $i++)
	{
		echo "<option value=\"" . "$i". ";" .$row["name"] . "\"" . ">" . $i . "</option>";
	}
	echo "</select> <br \>";
	echo "<input type=\"submit\" value=\"Ajouter au Panier\" />";
	echo "</div>";

}

function	is_already_in_shopping_cart($product_name)
{
	for($i = 0; $i < count($_SESSION["shopping cart"]); $i++)
	{
		foreach($_SESSION["shopping cart"][$i] as $elem)
		{
			if (key_exists($product_name, $_SESSION["shopping cart"][$i]))
				return ($i);
		}
	}
	return (-1);
}

function add_command_to_shopping_cart()
{
	$i = strpos($_POST["command"], ';');
	$quantity = substr($_POST["command"], 0, $i);
	$product_name = substr($_POST["command"], $i + 1);
	if (!key_exists("shopping cart", $_SESSION))
	{
		$array = array("$product_name" => $quantity);
		$_SESSION["shopping cart"][] = $array;
	}
	else
	{
		$index = is_already_in_shopping_cart($product_name);
		if ($index !== -1)
			$_SESSION["shopping cart"][$index][$product_name] += $quantity;
		else
		{
			$array = array("$product_name" => $quantity);
			$_SESSION["shopping cart"][] = $array;
		}
	}
}


function show_categories_list()
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$sql = "SELECT * FROM categories;";
	$result = mysqli_query($conn, $sql);
	echo "<form method=\"post\" action=\"index.php\">";
	echo "<select name=\"categorie\">";
	while($row = mysqli_fetch_array($result))
	{
		if (isset($row["nom"]) && isset($row['id']))
		{
			echo "<option value=\"" .$row['id'] . "\">" .$row["nom"] . "</option>";
		}
	}
	echo "</select>";
	echo "<input type=\"submit\" name=\"submit\" value=\"TRIER\"/>";
	echo "</form>";
	mysqli_close($conn);
}

?>

<html>
	<head>
		<title> 42 Shop </title>
		<link rel="stylesheet" type="text/css" href="shop.css">
	</head>
<body>
<h1> <br \> <br \> BIENVENUE SUR LA BOUTIQUE </h1>

<?php
header_menu();
show_content();
if (isset($_POST["command"]))
	add_command_to_shopping_cart();

?>
<ul class="left">
  <li class="trier">TRIER PAR CATEGORIES:</li>
  <?php show_categories_list(); ?>
</ul>

</body>
</html>
<style>
.trier{color: white;}
.left{
  list-style-type: none;
  margin-top: -480px;
  padding: 20px 20px 20px 50px;
  width: 7%;
  height: 20%;
  background-image: linear-gradient(90deg, salmon, orange);
  border-radius: 10px 10px 10px 10px;
}
li{
  display: block;
  color: #000;
  padding: 8px 0px;
  text-decoration: none;

}

li a:hover {
  background-color: #555;
  color: white;
  border-radius: 10px 10px 10px 10px;
}
</style>