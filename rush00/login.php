<?php

session_start();

function	auth($login, $passwd)
{
	$main_array = array();
	$main_array = unserialize(file_get_contents("../private/passwd"));
	$hashed = hash("whirlpool", $passwd);
	foreach ($main_array as $users)
	{
		if ($users["login"] === $login && $users["passwd"] === $hashed)
			return true;
	}
	return false;
}

function	is_logged_in()
{
	if (isset($_POST["login"]) && $_POST["login"] !== "" && isset($_POST["passwd"]) && $_POST["passwd"] !== "")
	{
		if (auth($_POST["login"], $_POST["passwd"]) === true)
		{
			$_SESSION["loggued_on_user"] = $_POST["login"];
			return (true);
		}
		else
		{
			$_SESSION["loggued_on_user"] = "";
			return (false);
		}
	}
	else
		return (false);
}

if (is_logged_in() === false)
{
	echo("<html> <meta charset=\"UTF-8\">");
	echo ("La tentative d'authentification à échouée");
	echo ("<br \>");
	echo ("(Mauvais mot de passe/login)");
	Header("refresh:3; url=login.html");
}
else
{
	Header("Location: index.php");
}
