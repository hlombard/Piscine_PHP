#!/usr/bin/php
<?php
if ($argc < 2 || $argv[1] == '')
	return;

//Check for string composed of only spaces, then don't return anything
if (strlen($argv[1]) > 0 && strlen(trim($argv[1], ' ')) == 0)
	return;
	
function ft_split($str)
{
	$tab = explode (" ", $str);
	$tab = array_filter($tab);
	return ($tab);
}
$tab = ft_split($argv[1]);
$first = array_shift($tab);
foreach ($tab as $elem)
	print_r($elem." ");
print_r($first."\n");
?>
