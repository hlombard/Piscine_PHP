<?php

session_start();
include 'admin_utils.php';

if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	echo "<h2> Espace Admin: Gestion des categories </h2>";
	?>
	<link rel="stylesheet" type="text/css" href="manage.css">
	<div class="manage_categories">
    <div> <h3> Ajouter une Catégorie </h3>
		<form action="admin_add_categorie.php" method="post">
 			<p>Nom de Catégorie : <input type="text" name="name" /></p>
 			<p><input type="submit" name="submit" value="CREER CATEGORIE"></p>
		</form>
    </div>
	<div> <h3> Modifier une Catégorie </h3>
		<form action="admin_modify_categorie.php" method="post">
 			<p>Catégorie ID: <input type="text" name="categorieID" /></p>
 			<p>Nom de Catégorie <input type="text" name="name" /></p>
 			<p><input type="submit"  name="submit" value="MODIFIER CATEGORIE"></p>
		</form>
    </div>
	<div> <h3> Supprimer une Catégorie</h3>
		<form action="admin_del_categorie.php" method="post">
 			<p>Catégorie ID: <input type="text" name="categorieID" /></p>
 			<p><input type="submit"  name="submit" value="SUPPRIMER CATEGORIE"></p>
		</form>
    </div>
	<div class="cat_infos"> <h3> Informations Catégories<br \> (10 premières) </h3>
	<?php display_first_10_categories(); ?>
	</div>

	<style>
.cat_infos ul {
	list-style: none;
	text-align: left;
	font-weight: bold;
	font-size: 1vw;
  }
.cat_infos ul li::before{content: "•"; color: red;
	display: inline-block;
	width: 1em;
	height: 1em;
	margin-left: -1em;}
	</style>

<?php
}
else
	echo "<h2> Cet espace est reservé aux admins </h2>";


function	display_first_10_categories()
{	
	$array = store_first_10_categories();
	echo "<br \> <ul>";
	foreach($array as $key => $elem)
	{
		echo "<li>";
		echo $key . ":";
		echo " " . $elem;
		echo "<br \>";
		echo "</li>";
	}
	echo "</ul>";
}

function	store_first_10_categories()
{
	$array = array();
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$sql = "SELECT * FROM categories limit 10";
	$result = mysqli_query($conn, $sql);
	while ($row =  mysqli_fetch_array($result))
		$array[$row['id']] = $row['nom']; 
	mysqli_close($conn);
	return ($array);
}