#!/usr/bin/php
<?php
if ($argc < 3)
	return;
$i = 0;
$array = array();
$argv = array_reverse($argv);
while ($i < $argc - 2)
{
	$array = explode(':', $argv[$i]);
	if ($array[0] == $argv[$argc - 2])
	{
		print_r($array[1]."\n");
		return;
	}
	$i++;
}
?>
