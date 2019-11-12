<?php
 

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


if (isset($_POST["login"]) && $_POST["login"] !== "" && isset($_POST["passwd"]) && $_POST["passwd"] !== "" && isset($_POST["submit"]))
{
	if ($_POST["submit"] === "OK")
	{
		if (file_exists("../private") === false)
			mkdir("../private", 0777, true);
		$main_array = array();
		if (file_exists("../private/passwd"))
			$main_array = unserialize(file_get_contents("../private/passwd"));
		if (username_exists($main_array) === 1)
		{
			header("Location: register_error.php?login=".$_POST["login"]);
			return;
		}
		$hashed_pw = hash("whirlpool", $_POST["passwd"]);
		$array[] = array("login" => $_POST["login"], "passwd" => $hashed_pw);
		array_push($main_array, $array[0]);
		$main_array = serialize($main_array);
		file_put_contents("../private/passwd", $main_array);
		echo "<h1> Votre compte a bien été créé !" . " (" . $_POST["login"] . ") </h1>";
		header("refresh:3; url=index.php");
	}
}
else
{
	echo "<h2> Vous devez remplir tout les champs... </h2>";
	header("refresh:3; url=register.html");
}
?>
