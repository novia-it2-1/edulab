<?php

	$conn = mysql_connect("edulab.db.9102600.hostedresource.com", "edulab", "T1t1K@k@");
	mysql_select_db('edulab');
	
	$id = $_POST['postId'];
	$select = mysql_query('SELECT date FROM parts_resources_link WHERE resource_id = ' . $id);
	//$rows = mysql_fetch_assoc($select);
	
	while($rows = mysql_fetch_assoc($select))
	{
		$r[] = array("date" => date("Y-n-j",strtotime($rows["date"])));
	}
	echo json_encode($r);
?>