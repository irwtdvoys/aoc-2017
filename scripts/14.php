<?php
	ini_set("memory_limit", -1);
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Defrag;

	$helper = new Defrag(14);
	$helper->run()->output();

	// Part 1: 8214
	// Part 2: 1093
?>
