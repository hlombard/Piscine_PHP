#!/usr/bin/php
<?php
if ($argc != 2)
	exit("Incorrect Parameters\n");

$array = sscanf($argv[1], "%f %c %f %s");

if (isset($array[0]) === true && isset($array[1]) === true && isset($array[2]) === true && isset($array[3]) === false)
{
	if($array[1] === '+')
		print_r($array[0] + $array[2]."\n");
	else if($array[1] === '-')
		print_r($array[0] - $array[2]."\n");
	else if($array[1] === '*')
		print_r($array[0] * $array[2]."\n");
	else if($array[1] === '/')
		print_r($array[0] / $array[2]."\n");
	else if($array[1] === '%')
		print_r($array[0] % $array[2]."\n");
}
else
	exit("Syntax Error\n");
?>
