<?php

session_start();
include 'admin_utils.php';

if ($_SESSION["loggued_on_user"] !== NULL && current_user_is_admin() == true)
{
	if (isset($_POST["login"]) && $_POST["login"] !== "" && isset($_POST["passwd"]) && $_POST["passwd"] !== "" && isset($_POST["submit"]))
	{
		if ($_POST["submit"] === "MODIFIER L'UTILISATEUR")
		{
			if (file_exists("../../private") === false)
				mkdir("../../private", 0777, true);
			$main_array = array();
			if (file_exists("../../private/passwd"))
				$main_array = unserialize(file_get_contents("../../private/passwd"));
			$id = login_id($main_array, $_POST["login"]);
			if ($id == -1)
			{
				echo "<h1> Echec: Cet Identifiant n'existe pas...</h1>";
				header("refresh:3; url=manage_users.php");
				return;
			}
			$hashed_pw = hash("whirlpool", $_POST["passwd"]);
			$main_array[$id]["passwd"] = $hashed_pw;
			$main_array = serialize($main_array);
			file_put_contents("../../private/passwd", $main_array);
			echo "<h1> Le Mot de Passe de l'utilisateur: " . $_POST["login"] . " a été changé !" . "</h1>";
			header("refresh:3; url=manage_users.php");
		}
	}
	else
	{
		echo "<h1> Echec: Tous les champs doivent etre renseigner...</h1>";
		header("refresh:3; url=manage_users.php");
	}
}
else
{
	echo "<h2> Restricted to admins </h2>";
}


function	login_id($array, $login)
{
	$i = 0;
	foreach($array as $elem)
	{
		if ($elem["login"] === $login)
			return ($i);
		$i++;
	}
	return (-1);
}

?>
