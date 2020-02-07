<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Reallocation;

	$helper = new Reallocation(6);
	$helper->run()->output();

	// Part 1: 4074
	// Part 2: 2793
?>
