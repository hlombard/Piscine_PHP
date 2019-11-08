#!/usr/bin/php
<?php
function parse_links($s)
{
    $result = array();
    preg_match_all("/<a.*?<\/a>/s", $s, $a);
	foreach ($a[0] as $el)
	{
        preg_match_all("/title=\"(.*?)\"|>(.*?)</s", $el, $text);
		for ($i = 1; $i < count($text); $i++)
		{
            $text[$i] = array_filter($text[$i]);
			if (!empty($text[$i]))
			{
                foreach ($text[$i] as $t)
                    $result[] = $t;
            }
        }
    }
    if (!empty($result))
        return $result;
}

if ($argc != 2 || !file_exists($argv[1]))
	return;
$content = file_get_contents($argv[1]);
if ($content === false)
{
	echo("file: \"$argv[1]\" " . "cannot be read\n");
	return;
}
$results = parse_links($content);
if (empty($results))
	return;
foreach ($results as $result)
	$content = str_ireplace($result, strtoupper($result), $content);
echo $content;

?>
