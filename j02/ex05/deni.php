#!/usr/bin/php
<?php
if ($argc != 3)
    return;

if (!file_exists($argv[1]))
    return;
$fd = fopen($argv[1], 'r');
$line = trim(fgets($fd));
$infos = explode(';', $line);
if (in_array($argv[2], $infos) == false)
    return;

$key = $argv[2];
$elements = array();
$array = array();
$elem = 0;
foreach($infos as $id => $arr)
{
    $elements[$arr] = $arr;
    $array[$arr] = [];
    if ($argv[2] == $arr)
        $elem = $id;
}
while (! feof ($fd))
{
    $line = trim(fgets($fd));
    if (empty($line))
        break;
    $tmp = explode(';', $line);
    $i = 0;
    foreach($elements as $infos)
    {
        $array[$infos][$tmp[$elem]] = $tmp[$i];
        $i++;
	}
}

extract($array);
fclose($fd);

while (1)
{
    $fd = fopen("php://stdin", "r");
    echo "Entrez votre commande : ";
	$instructions = fgets($fd);
	if (feof($fd) === true)
	{
		echo "\n";
		break;
	}
	try
	{
    	eval($instructions);
	}
	catch (Throwable $t)
	{
		echo "PHP Parse error:  " . $t->getMessage() . "\n";
	}
    fclose($fd);
}
?>
