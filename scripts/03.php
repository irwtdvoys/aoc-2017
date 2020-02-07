<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\SpiralMemory;

	$helper = new SpiralMemory(3);
	$helper->run()->output();

	// Part 1: 326
	// Part 2: 363010
?>
