<?php
	ini_set("memory_limit", -1);
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Art;

	$helper = new Art(21/*, ROOT . "data/21/example"*/);
	$helper->run()->output();

	// Part 1: 117
	// Part 2: 2026963
?>
