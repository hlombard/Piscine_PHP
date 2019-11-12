<?php

include 'administration/admin_utils.php';
session_start();


if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin())
{
	echo "<h2> Espace ADMIN </h2>";
	echo "<br \>";
	echo("<h3> <a href=\"administration/manage_products.php\"> Gestion produits </a> </h3>");
	echo("<h3> <a href=\"administration/manage_users.php\"> Gestion utilisateurs </a> </h3>");
	echo("<h3> <a href=\"administration/manage_orders.php\"> Gestion commandes </a> </h3>");
	echo("<h3> <a href=\"administration/manage_categories.php\"> Gestion des catégories </a> </h3>");
}
else
	echo "<h2> Cet espace est reservé aux admins </h2>";
