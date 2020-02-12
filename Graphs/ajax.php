<?php

header('Content-Type: application/json');

// Set up the ORM library
require_once('setup.php');

if (isset($_GET['start']) AND isset($_GET['end'])) {
	
	$start = $_GET['start'];
	$end = $_GET['end'];
	$data = array();

	// Select the results with Idiorm
	$results = ORM::for_table('sales')
			->where_gte('date_add', $start)
			->where_lte('price', $end)
			//->where_lte('price', $end)
			->order_by_asc('date_add')
			->find_array();


	// Build a new array with the data
	foreach ($results as $key => $value) {
		$data[$key]['label'] = $value['date_add'];
		$data[$key]['value'] = $value['price'];
	}

	echo json_encode($data);
}
