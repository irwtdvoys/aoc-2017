<?php
	ini_set("memory_limit", -1);
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Moat;

	$helper = new Moat(24);//, ROOT . "data/24/example");
	$helper->run()->output();

	// Part 1: 1906
	// Part 2: 1824
?>
