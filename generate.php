<?php
	$json['success'] = TRUE;

	try
	{
		$long_url = (isset($_POST['long_url'])) ? $_POST['long_url'] : '';
		$long_url = (preg_match('/^http/', $long_url)) ? $long_url : 'http://' . $long_url;

		$server = 'localhost';
		$database = 'krep4324_shorturl';
		$username = 'krep4324_hendri';
		$password = 'h3ndr1';

		$mysqli = new mysqli($server, $username, $password, $database);

		$sql = 'SELECT shorturl ';
		$sql .= 'FROM list ';
		$sql .= "WHERE longurl = '{$long_url}'";
		$query = $mysqli->query($sql);

		$arr_data = array();

		while ($row = $query->fetch_object())
		{
			$arr_data[] = clone $row;
		}

		$query->free_result();

		if (count($arr_data) > 0)
		{
			$json['shorturl'] = 'http://sufh.xyz/'.$arr_data[0]->shorturl;

			header('Content-Type: application/json');
			ob_clean();
			flush();
			echo json_encode($json);
			exit(1);
		}

		$short_url = generate_short_url($long_url);

		$sql_insert = 'INSERT INTO list (shorturl, longurl) ';
		$sql_insert .= "VALUES('{$short_url}', '{$long_url}')";
		$mysqli->query($sql_insert);

		$json['shorturl'] = 'http://sufh.xyz/'.$short_url;
	}
	catch (Exception $e)
	{
		$json['success'] = FALSE;
		$json['message'] = ($e->getMessage() == '') ? 'Server Error' : $e->getMessage();
	}

	header('Content-Type: application/json');
	ob_clean();
	flush();
	echo json_encode($json);
	exit(1);

	function generate_short_url($long_url)
	{
		$text = crypt(md5(time() . $longurl . 'shorturl'));

		$arr_text = str_split($text);
		$arr_short_url = array();

		for ($i = 0; $i < strlen($text); $i++)
		{
			if ($i % 5 != 0)
			{
				continue;
			}

			$arr_short_url[] = $arr_text[$i];
		}

		return substr(implode('', $arr_short_url), 0, 5);
	}
?>