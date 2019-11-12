<?php

session_start();
include 'admin_utils.php';

if ($_SESSION["loggued_on_user"] !== "" && current_user_is_admin() == true)
{
	if (isset($_POST["login"]) && $_POST["login"] !== "" && isset($_POST["passwd"]) && $_POST["passwd"] !== "" && isset($_POST["submit"]))
	{
		if ($_POST["submit"] === "CREER L'UTILISATEUR")
		{
			if (isset($_POST["give_admin"]) && $_POST["give_admin"] == "give")
				set_admin_rights($_POST["login"]);
			if (file_exists("../../private") === false)
				mkdir("../../private", 0777, true);
			$main_array = array();
			if (file_exists("../../private/passwd"))
				$main_array = unserialize(file_get_contents("../../private/passwd"));
			if (username_exists($main_array) === 1)
			{
				echo "<h1> Echec: Cet Identifiant est déjà utilisé...</h1>";
				header("refresh:3; url=manage_users.php");
				return;
			}
			$hashed_pw = hash("whirlpool", $_POST["passwd"]);
			$array[] = array("login" => $_POST["login"], "passwd" => $hashed_pw);
			array_push($main_array, $array[0]);
			$main_array = serialize($main_array);
			file_put_contents("../../private/passwd", $main_array);
			echo "<h1> L'utilisateur: " . $_POST["login"] . " a été ajouté" . "</h1>";
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

function set_admin_rights($login)
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$login = mysqli_real_escape_string($conn, $login);
	$sql = "INSERT INTO admin (login) VALUES ('$login');";
	mysqli_query($conn, $sql);
	mysqli_close($conn);
}



function	username_exists($tab)
{
	foreach($tab as $user)
	{
		if ($user["login"] === $_POST["login"])
		{
			return (1);
		}
	}
	return (0);
}

?>
