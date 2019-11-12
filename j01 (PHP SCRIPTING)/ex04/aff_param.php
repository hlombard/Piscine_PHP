#!/usr/bin/php
<?php
$i = 0;
foreach ($argv as $param)
{
    if ($i > 0)
        print_r("$param"."\n");
    $i++;
}
?>
