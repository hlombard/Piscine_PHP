<?php

include "auth.php";
session_start();

$show_chat = 0;
if (isset($_POST["login"]) && $_POST["login"] !== "" && isset($_POST["passwd"]) && $_POST["passwd"] !== "")
{
	if (auth($_POST["login"], $_POST["passwd"]) === true)
	{
		$_SESSION["loggued_on_user"] = $_POST["login"];
		$show_chat = 1;
	}
	else
	{
		$_SESSION["loggued_on_users"] = "";
	}
}

if ($show_chat === 1)
{
	?>

	<html>
	<head>
		<meta charset="UTF-8">
		<title>hlombard Chat</title>
	</head>
	<body>
		<a href="logout.php">Se déconnecter</a>
		<iframe name="chat" src="chat.php" width="100%" height="550px"></iframe>
		<iframe name="speak" src="speak.php" width="100%" height="50px"></iframe>
	</body>
	</html>
	<?php
}
?>

