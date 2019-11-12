<?php

include 'admin_orders_utils_func.php';
include 'admin_utils.php';

session_start();
if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	echo "<h2> Espace Admin: Gestion de commandes </h2>";
	?>
	<link rel="stylesheet" type="text/css" href="manage.css">
	<div class="manage_orders">
    <div> <h3> Ajouter une commande </h3>
		<form action="admin_add_order.php" method="post">
 			<p>Login : <input type="text" name="login" /></p>
			 <p>Commande (produit,quantité;...) : <input type="text" name="command" /></p>
 			<p><input type="submit" name="submit" value="CREER COMMANDE"></p>
		</form>
    </div>
	<div> <h3> Modifier une commande </h3>
		<form action="admin_modify_order.php" method="post">
			 <p>ID Commande : <input type="text" name="commandID" /></p>
			 <p>Commande (produit,quantité;...) : <input type="text" name="command" /></p>
 			<p><input type="submit"  name="submit" value="MODIFIER COMMANDE"></p>
		</form>
    </div>
	<div> <h3> Supprimer une commande </h3>
		<form action="admin_del_order.php" method="post">
 			<p>ID Commande: <input type="text" name="commandID" /></p>
 			<p><input type="submit"  name="submit" value="SUPPRIMER COMMANDE"></p>
		</form>
    </div>
	<div class="command_infos"> <h3> Informations Commandes: <br \> (5 premieres) </h3>
	<?php display_first_5_orders(); ?>
	</div>

	<style>
.command_infos ul {
	list-style: none;
	text-align: left;
	font-weight: bold;
	font-size: 0.5vw;
  }
.command_infos ul li::before{content: "•"; color: red;
	display: inline-block;
	width: 1em;
	height: 1em;
	margin-left: -1em;}
	</style>
<?php
}
else
	echo "<h2> Cet espace est reservé aux admins </h2>";


function	display_first_5_orders()
{	
	$array = store_first_5_orders();
	echo "<br \> <ul>";
	foreach($array as $key => $elem)
	{
		echo "<li>";
		echo $key . " - ";
		$login = array_key_first($elem);
		echo "login: " . $login;
		$tmp = unserialize($elem[$login]);
		echo "<br \>";
		foreach($tmp as $key2 => $elem2)
		{
			echo "-" . $key2 . ", " . $elem2;
			echo "<br \>";
		}
		echo "<br \>";
		echo "</li>";
	}

	echo "</ul>";
}

function	store_first_5_orders()
{
	$array = array();
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$sql = "SELECT * FROM orders limit 5";
	$result = mysqli_query($conn, $sql);
	while ($row =  mysqli_fetch_array($result))
		$array[$row['id']][$row['login']] = $row['commande']; 
	mysqli_close($conn);
	return ($array);
}



?>
