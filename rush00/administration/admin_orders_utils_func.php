<?php

function	create_command_serialized()
{
	$array = explode(';', trim($_POST["command"]));
	$array = array_filter($array);
	$new = array();
	foreach($array as $key =>$elem)
	{
		$tmp = explode(',', $elem);
		$str1 = $tmp[0];
		$str2 = $tmp[1];
		$new[$str1] = $str2;
	}
	return (serialize($new));
}

function	is_valid_command()
{
	$array = explode(';', trim($_POST["command"]));
	$array = array_filter($array);
	foreach($array as $key => $elem)
	{
		if (!strstr($elem, ','))
			return (false);
		$split = explode(',', $elem);
		if (product_exists($split[0]) == false)
			return (false);
		if (enough_quantity($split[0], $split[1]) == false)
			return (false);
	}
	return (true);
}

function	product_exists($product)
{
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$sql = "SELECT name FROM products WHERE name=" . "'$product';";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	if (!$row)
		return (false);
	else
		return (true);
}

function 	enough_quantity($product, $quantity)
{
	if (!is_numeric($quantity) || $quantity == 0)
		return (false);
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
		die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$sql = "SELECT stock FROM products WHERE name=" . "'$product';";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	if ($row["stock"] < $quantity)
		return (false);
	else
		return (true);
}

?>