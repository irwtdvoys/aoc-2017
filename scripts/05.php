<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Jumps;

	$helper = new Jumps(5);
	$helper->run()->output();

	// Part 1: 364539
	// Part 2: 27477714
?>
