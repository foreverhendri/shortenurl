<?php
	if ($_SERVER['REQUEST_URI'] == '' || $_SERVER['REQUEST_URI'] == '/')
	{
		header('Location: http://sufh.xyz/su.php');
		exit();
	}

	$server = 'localhost';
	$database = 'krep4324_shorturl';
	$username = 'krep4324_hendri';
	$password = 'h3ndr1';

	$mysqli = new mysqli($server, $username, $password, $database);

	$shorturl = str_replace('/', '', $_SERVER['REQUEST_URI']);

	$sql = 'SELECT longurl ';
	$sql .= 'FROM list ';
	$sql .= "WHERE shorturl = '{$shorturl}'";
	$query = $mysqli->query($sql);

	$arr_data = array();

	while ($row = $query->fetch_object())
	{
		$arr_data[] = clone $row;
	}

	$query->free_result();

	if (count($arr_data) <= 0)
	{
		header('Location: http://sufh.xyz/su.php');
		exit();
	}

	header('Location: ' . $arr_data[0]->longurl);
	exit();
?>