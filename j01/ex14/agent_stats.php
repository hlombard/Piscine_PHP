#!/usr/bin/php
<?php

if ($argc != 2)
    exit();
if ($argv[1] != "moyenne" && $argv[1] != "moyenne_user" && $argv[1] != "ecart_moulinette")
	exit();

$file = array();
$infos = array();
$stdin = fopen('php://stdin', 'r');

while (! feof ($stdin))
{
	$tmp = fgets($stdin);
	$tmp = explode(';', $tmp);
	array_push($file, $tmp);
	$name = $tmp[0];
	if (!isset($infos[$name]))
	{
		$infos[$name]["total"] = 0;
		$infos[$name]["nb"] = 0;
		$infos[$name]["by moulinette"] = 0;
	}
}

array_shift($file);
array_pop($file);
array_shift($infos);
array_pop($infos);

function moyenne($file)
{
	$total = 0;
	$nb = 0;
	foreach ($file as $line)
	{
		if ($line[1] != '' && $line[2] != "moulinette")
		 {
			$total += $line[1];
			$nb++;
		}
	}
	if ($nb > 0)
		echo($total / $nb . "\n");
}

function stock_infos($file, $infos)
{
	foreach ($file as $line)
	{
		if ($line[1] != '' && $line[2] != "moulinette")
		{
			$infos[$line[0]]["nb"] += 1;
			$infos[$line[0]]['total'] += $line[1];
		}
		else if ($line[2] == "moulinette")
		{
			$infos[$line[0]]["by moulinette"] += $line[1];
		}
	}
	return($infos);
}

function moyenne_user($file, $infos)
{
	$infos = stock_infos($file, $infos);
	foreach($infos as $name => $user)
	{
		if ($user["nb"] != 0)
		{
			echo($name . ':');
			echo($user['total'] / $user["nb"] . "\n");
		}
	}
}

function ecart_moulinette($file, $infos)
{
	$infos = stock_infos($file, $infos);
	foreach($infos as $name => $user)
	{
		if ($user["nb"] != 0)
		{
			echo($name . ':');
			echo(($user['total'] / $user["nb"]) - $user["by moulinette"] . "\n");
		}
	}
}

if ($argv[1] == "moyenne")
	moyenne($file);
else if ($argv[1] == "moyenne_user")
{
	ksort($infos);
	moyenne_user($file, $infos);
}
else
{
	ksort($infos);
	ecart_moulinette($file, $infos);
}

?>
