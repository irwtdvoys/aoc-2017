<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Duet;

	$helper = new Duet(18/*, ROOT . "data/18/example2"*/);
	$helper->run()->output();

	// Part 1: 3188
	// Part 2:
?>
