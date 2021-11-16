<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Swarm;

	$helper = new Swarm(20/*, ROOT . "data/20/example"*/);
	$helper->run()->output();

	// Part 1: 258
	// Part 2: 707
?>
