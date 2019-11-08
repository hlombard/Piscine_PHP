<?php

session_start();
include 'admin_utils.php';

if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	echo "<h2> Espace Admin: Gestion d'utilisateur </h2>";
	?>
	<link rel="stylesheet" type="text/css" href="manage.css">
	<div class="manage_users">
    <div> <h3> Ajouter un utilisateur </h3>
		<form action="admin_add_user.php" method="post">
 			<p>Identifiant : <input type="text" name="login" /></p>
			 <p>Mot de passe : <input type="text" name="passwd" /></p>
			 <input type="checkbox" id="giveAdmin" name="give_admin" value="give">
   			 <label for="giveAdmin">Donner les droits d'administration</label>
 			<p><input type="submit" name="submit" value="CREER L'UTILISATEUR"></p>
		</form>
    </div>
	<div> <h3> Modifier Un Utilisateur </h3>
		<form action="admin_modify_user.php" method="post">
 			<p>Identifiant : <input type="text" name="login" /></p>
 			<p>Nouveau Mot de passe : <input type="text" name="passwd" /></p>
 			<p><input type="submit"  name="submit" value="MODIFIER L'UTILISATEUR"></p>
		</form>
    </div>
	<div> <h3> Supprimer Un Utilisateur </h3>
		<form action="admin_del_user.php" method="post">
 			<p>Identifiant : <input type="text" name="login" /></p>
 			<p><input type="submit"  name="submit" value="SUPPRIMER L'UTILISATEUR"></p>
		</form>
    </div>
	<div class="users_infos"> <h3> Informations Utilisateurs: <br \> (10 premiers) </h3>
	<?php display_first_10_users(); ?>
	</div>

	<style>
.users_infos ul {
	list-style: none;
	text-align: left;
	font-weight: bold;
	font-size: 1vw;
  }
.users_infos ul li::before{content: "•"; color: red;
	display: inline-block;
	width: 1em;
	height: 1em;
	margin-left: -1em;}
	</style>

<?php
}
else
{
	echo "<h2> Cet espace est reservé aux admins </h2>";
	Header("refresh:3; url=../index.php");
}

function	display_first_10_users()
{
	if (file_exists("../../private/passwd"))
	{
		$main_array = unserialize(file_get_contents("../../private/passwd"));
		$main_array = array_values($main_array);
		echo "<br \> <ul>";
		for ($i = 0; $i < 10; $i++)
		{
			echo "<li>";
			if (isset($main_array[$i]))
			{
				if (isset($main_array[$i]["login"]))
					echo $main_array[$i]["login"];
			}
			echo "</li>";
		}
		echo "</ul>";
	}
}

?>
