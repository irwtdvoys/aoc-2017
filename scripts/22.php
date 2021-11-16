<?php
	ini_set("memory_limit", -1);
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Sporifica;

	$helper = new Sporifica(22);//, ROOT . "data/22/example");
	$helper->run()->output();

	// Todo: use SplObjectStorage

	// Part 1: 5433
	// Part 2: 2512599
?>
