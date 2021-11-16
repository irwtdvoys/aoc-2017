<?php
	ini_set("memory_limit", -1);
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Coprocessor;

	$helper = new Coprocessor(23);//, ROOT . "data/22/example");
	$helper->run()->output();

	// Part 1: 8281
	// Part 2: 911
?>
