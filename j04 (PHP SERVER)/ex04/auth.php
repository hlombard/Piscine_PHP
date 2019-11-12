<?php

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

?>
