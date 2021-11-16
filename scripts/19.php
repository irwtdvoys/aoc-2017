<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Tubes;

	$helper = new Tubes(19);
	$helper->run()->output();

	// Part 1: MKXOIHZNBL
	// Part 2: 17872
?>
