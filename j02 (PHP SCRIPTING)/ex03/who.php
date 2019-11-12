#!/usr/bin/php
<?php
	date_default_timezone_set("Europe/Paris");
	$fd = fopen("/var/run/utmpx", "r");
	$infos = array();
	while ($line = fread($fd, 628))
	{
		$line = unpack("a256user/a4id/a32line/ipid/itype/I2time/", $line);
		if (isset($line["type"]) && $line["type"] === 7)
		{
			array_push($infos, $line);
		}
	}
	sort($infos);
	foreach($infos as $elem)
	{
		echo $elem["user"] . ' ';
		echo $elem["line"] . ' ';
		echo date(" M j H:i ", $elem["time1"]);
		echo "\n";
	}
?>
