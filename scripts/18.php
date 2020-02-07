<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Duet;

	$helper = new Duet(18);
	$helper->run()->output();

	// Part 1:
	// Part 2:
?>
