<?php

function	current_user_is_admin()
{
	$user_name = $_SESSION["loggued_on_user"];
	$conn = mysqli_connect('localhost', 'root', 'rootroot', 'rush00');
	if(!$conn){
	   die('Could not connect: '.utf8_encode(mysqli_connect_error()));
	}
	$user_name = mysqli_real_escape_string($conn, $user_name);
	$sql = "SELECT login FROM admin WHERE login='$user_name';";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	mysqli_close($conn);
	if ($row === NULL)
		return (false);
	else
		return (true);
}


?>