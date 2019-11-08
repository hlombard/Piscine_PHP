#!/usr/bin/php
<?php

if ($argc != 2)
	return;

if (file_exists($argv[1]) === false)
	return;

$fd = fopen($argv[1], 'r');

if ($fd == false)
	return;


$array = array();

while (!feof($fd))
{

	$uselessvalue = fgets($fd);
	$time = trim(fgets($fd));
	$msg = fgets($fd);
	while (1)
	{
		$test = trim(fgets($fd));
		if (empty($test))
		{
			break;
		}
		$msg .= $test;
		$msg .= "\n";
	}
	if (empty($uselessvalue) || empty($time) || empty($msg))
		break;
	$array[$time]["msg"] = $msg;
}

ksort($array);

$i = 1;
$count = count($array);


foreach($array as $time => $elem)
{
	echo $i . "\n";
	echo $time . "\n";
	echo $elem["msg"];
	if ($i < $count)
		echo "\n";
	else
		return;
	$i++;
}


?>

