<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\HexGrid;

	$helper = new HexGrid(11);
	$helper->run()->output();

	// Part 1: 682
	// Part 2: 1406
?>
