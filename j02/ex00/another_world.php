#!/usr/bin/php
<?php

if ($argc >= 2)
{
    $str= preg_replace("/(^[ \t]+)|([ \t]+$)/", "", $argv[1]);
    $str = preg_replace("/[ \t]+/", " ", $str);
    echo $str . "\n";
}

?>
