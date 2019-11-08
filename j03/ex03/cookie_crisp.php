<?php

if ($_GET['action'] == 'set')
{
	setcookie($_GET['name'], $_GET['value']);
}
else if ($_GET['action'] == 'get' && isset($_COOKIE[$_GET['name']]))
{
	echo $_COOKIE[$_GET['name']] . PHP_EOL;
}
else if ($_GET['action'] == 'del')
{
	setcookie($_GET['name'], "", time() - 3600);
}

?>
