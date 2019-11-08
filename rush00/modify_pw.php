<?php

session_start();

function	login_pw_match($tab, $oldpw)
{
	$i = 0;
	foreach($tab as $user)
	{
		if ($user["login"] === $_SESSION["loggued_on_user"] && $user["passwd"] === $oldpw)
		{
			return ($i);
		}
		$i++;
	}
	echo "<h2> Mauvais Mot De Passe... </h2>";
	echo "<h4> Veuillez réessayer... </h4>";
	return (-1);
}

if (isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] !== "" && isset($_POST["oldpw"]) && $_POST["oldpw"] !== ""
	&& isset($_POST["newpw"]) && $_POST["newpw"] !== "" && isset($_POST["submit"]))
{
	if ($_POST["submit"] === "OK")
	{
		$oldpw = hash("whirlpool", $_POST["oldpw"]);
		$main_array = unserialize(file_get_contents("../private/passwd"));
		$key = login_pw_match($main_array, $oldpw);
		if ($key === -1)
		{
			Header("refresh:3; url=modify_pw.html");
			return;
		}
		$newpw = hash("whirlpool", $_POST["newpw"]);
		$main_array[$key]["passwd"] = $newpw;
		file_put_contents("../private/passwd", serialize($main_array));
		echo "<h2> Votre Mot de Passe a été changé";
		Header("refresh:3; url=index.php");
	}
}
else
	echo "<h2> ERROR </h2>";
?>

