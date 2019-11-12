#!/usr/bin/php
<?php
function ft_split($str)
{
    $tab = explode (" ", $str);
    $tab = array_filter($tab);
    sort($tab);
    return ($tab);
}
$array = array();
$i = 0;
foreach ($argv as $str)
{
    if ($i > 0)
    {
        $small_array = ft_split($str);
        $array = array_merge($array, $small_array);
    }
    $i++;
}
sort($array);
foreach($array as $word)
    print_r($word."\n");
