#!/usr/bin/php
<?php
if ($argc != 2)
	return;
$stripped = trim(preg_replace('/ +/', ' ', $argv[1]), " ");
print_r($stripped."\n");
?>
