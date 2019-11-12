<?php

function	login_pw_match($tab, $oldpw)
{
	$i = 0;
	foreach($tab as $user)
	{
		if ($user["login"] === $_POST["login"] && $user["passwd"] === $oldpw)
		{
			return ($i);
		}
		$i++;
	}
	echo "ERROR\n";
	return (-1);
}


if (isset($_POST["login"]) && $_POST["login"] !== "" && isset($_POST["oldpw"]) && $_POST["oldpw"] !== ""
	&& isset($_POST["newpw"]) && $_POST["newpw"] !== "" && isset($_POST["submit"]))
{
	if ($_POST["submit"] === "OK")
	{
		$oldpw = hash("whirlpool", $_POST["oldpw"]);
		$main_array = unserialize(file_get_contents("../private/passwd"));
		$key = login_pw_match($main_array, $oldpw);
		if ($key === -1)
			return;
		$newpw = hash("whirlpool", $_POST["newpw"]);
		$main_array[$key]["passwd"] = $newpw;
		file_put_contents("../private/passwd", serialize($main_array));
		echo "OK\n";
		refresh("Location: index.html");
	}
	else
		echo "ERROR\n";
}
else
	echo "ERROR\n";


?>
