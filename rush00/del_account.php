<?php
session_start();

function	find_index_user($main_array)
{
	foreach($main_array as $key => $user)
	{
		if ($user["login"] === $_SESSION["loggued_on_user"])
			return ($key);
	}
	return (-1);
}

if (isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] !== "")
{
	if (file_exists("../private/passwd"))
		$main_array = unserialize(file_get_contents("../private/passwd"));
	$index = find_index_user($main_array);
	if ($index != -1)
	{
		unset($main_array[$index]);
		$main_array = serialize($main_array);
		file_put_contents("../private/passwd", $main_array);
		echo "<h2> Your account was Deleted ! </h2>";
		$_SESSION["loggued_on_user"] = "";
		if (isset($_SESSION["buy"]) && $_SESSION["buy"])
			unset($_SESSION["buy"]);
		if (isset($_SESSION["shopping cart"]) && $_SESSION["shopping cart"])
			unset($_SESSION["shopping cart"]);
		Header("refresh:5; url=index.php");
	}
}
?>
