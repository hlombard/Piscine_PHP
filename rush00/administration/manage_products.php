<?php

session_start();
include 'admin_utils.php';

if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	echo "<h2> Espace Admin: Gestion de produit </h2>";
	?>	
	<div class="manage_products">
    <div> <h3> Ajouter un Produit </h3>
		<form action="admin_add_product.php" method="post">	
 			<p>Nom : <input type="text" name="name" /></p> 
 			<p>Prix : <input type="text" name="prix" /></p> 
 			<p>Stock : <input type="text" name="stock" /></p>
 			<p>image url : <input type="text" name="url" /></p>
 			<p>ID catégorie (optionnel): <input type="text" name="catID" /></p>
 			<p><input type="submit" name="submit" value="CREER PRODUIT"></p>
		</form>
    </div>
	<div> <h3> Modifier un Produit </h3>
		<form action="admin_modify_product.php" method="post">
			 <p>ID Produit : <input type="text" name="prodID" /></p>
			<p>Nom : <input type="text" name="name" /></p> 
 			<p>Prix : <input type="text" name="prix" /></p> 
 			<p>Stock : <input type="text" name="stock" /></p>
 			<p>image url : <input type="text" name="url" /></p>
 			<p>ID catégorie (optionnel): <input type="text" name="catID" /></p>
 			<p><input type="submit"  name="submit" value="MODIFIER PRODUIT"></p>
		</form>
    </div>
	<div> <h3> Supprimer un Produit </h3>
		<form action="admin_del_product.php" method="post">
 			<p>ID Produit : <input type="text" name="id" /></p>
 			<p><input type="submit"  name="submit" value="SUPPRIMER PRODUIT"></p>
		</form>
    </div>
	<div class="products_infos"> <h3> Informations Produits: <br \> (10 premiers) </h3>
	<?php display_first_10_products(); ?>
	</div>
<?php
}
else
	echo "<h2> Cet espace est reservé aux admins </h2>";


function	display_first_10_products()
{	
	$array = store_first_10_products();
	echo "<br \> <ul>";
	foreach($array as $key => $elem)
	{
		echo "<li>";
		echo $key . " : ";
		echo $elem;
		echo "<br \>";
		echo "</li>";
	}
	echo "</ul>";
}

function	store_first_10_products()
{
	$array = array();
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$sql = "SELECT * FROM products limit 10";
	$result = mysqli_query($conn, $sql);
	while ($row =  mysqli_fetch_array($result))
		$array[$row['id']] = $row['name']; 
	mysqli_close($conn);
	return ($array);
}

?>
<style>
.manage_products {
	display: flex;
	justify-content: center;
	background-color: DodgerBlue;
	height: 50%;
  }
.manage_products > div {
	background-color: #f1f1f1;
	width: 25%;
	margin: 10px;
	text-align: center;
}
.manage_products > div p {font-size: 15px;}
.products_infos ul {
	list-style: none;
	text-align: left;
	font-weight: bold;
	font-size: 1vw;
  }
.products_infos ul li::before{content: "•"; color: red;
	display: inline-block;
	width: 1em;
	height: 1em;
	margin-left: -1em}
</style>