<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Stream;

	$helper = new Stream(9);
	$helper->run()->output();

	// Part 1: 12396
	// Part 2: 6346
?>
