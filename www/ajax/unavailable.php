<?php

	$conn = mysql_connect("localhost", "root", "");
	mysql_select_db('edulab');
	
	$id = $_POST['postId'];
	$select = mysql_query('SELECT date FROM parts_resources_link WHERE resource_id = ' . $id);
	//$rows = mysql_fetch_assoc($select);
	$r = array();
	while($rows = mysql_fetch_assoc($select))
	{
		//echo $rows["date"] . ";";
		$r[]=$rows;
	}
	echo json_encode($r);
	//$json = json_encode($rows);
	//echo $json;
?>