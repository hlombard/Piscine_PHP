#!/usr/bin/php
<?php

if ($argc != 2)
    return;

$elem = explode(' ', $argv[1]);
if (count($elem) != 5)
{
    echo("Wrong Format\n");
    return;
}

date_default_timezone_set("Europe/Paris");
$show_error = 0;

/*
Check validty of week day
*/

if (!preg_match("/^([Ll]undi|[Mm]ardi|[Mm]ercredi|[Jj]eudi|[Vv]endredi|[Ss]amedi|[Dd]imanche)$/", $elem[0]))
    $show_error = 1;

/*
Check validity of month
*/

if (preg_match("/^[Jj]anvier$/", "$elem[2]") == 1)
	$month = 1;
else if (preg_match("/^[Ff]évrier$/", "$elem[2]") == 1)
	$month = 2;
else if (preg_match("/^[Mm]ars$/", "$elem[2]") == 1)
	$month = 3;
else if (preg_match("/^[Aa]vril$/", "$elem[2]") == 1)
	$month = 4;
else if (preg_match("/^[Mm]ai$/", "$elem[2]") == 1)
	$month = 5;
else if (preg_match("/^[Jj]uin$/", "$elem[2]") == 1)
	$month = 6;
else if (preg_match("/^[Jj]uillet$/", "$elem[2]") == 1)
	$month = 7;
else if (preg_match("/^[Aa]o[ûu]t$/", "$elem[2]") == 1)
	$month = 8;
else if (preg_match("/^[Ss]eptembre$/", "$elem[2]") == 1)
	$month = 9;
else if (preg_match("/^[Oo]ctobre$/", "$elem[2]") == 1)
	$month = 10;
else if (preg_match("/^[Nn]ovembre$/", "$elem[2]") == 1)
	$month = 11;
else if (preg_match("/^[Dd]écembre$/", "$elem[2]") == 1)
	$month = 12;
else
	$month = -1;

/*
Check validty of hour:min:sec
*/
if (!preg_match("/^([0-9][0-9]):([0-9][0-9]):([0-9][0-9])$/", $elem[4], $elem[4]))
	$show_error = 1;

/*
Check validity of $year, $month and $day
*/

$year = $elem[3];
if (strlen($year) != 4 || is_numeric($year) === false)
	$show_error = 1;

$day = $elem[1];
if (strlen($day) > 2 || is_numeric($day) === false)
	$show_error = 1;

if ($month == -1)
	$show_error = 1;


/*
End of program, give output.
*/

if ($show_error == 1)
    echo("Wrong Format\n");
else
{
    $hour = explode(':', $elem[4][0]);
	$time = mktime($hour[0], $hour[1], $hour[2], $month, $day, $year);
	echo "$time\n";
}


?>
