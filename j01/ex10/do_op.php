#!/usr/bin/php
<?php
if ($argc != 4)
{
	print_r("Incorrect Parameters\n");
	return;
}

$av1 = trim($argv[1], " \t");
$av2 = trim($argv[2], " \t");
$av3 = trim($argv[3], " \t");

if ($av1 === NULL || $av3 === NULL || !is_numeric($av1) || !is_numeric($av3))
	return;

$av1 = floatval($av1);
$av3 = floatval($av3);
if ($av2 === '+')
	print_r($av1 + $av3."\n");
if ($av2 === '-')
	print_r($av1 - $av3."\n");
if ($av2 === '*')
	print_r($av1 * $av3."\n");
if ($av2 === '/')
	print_r($av1 / $av3."\n");
if ($av2 === '%')
	print_r($av1 % $av3."\n");
?>
