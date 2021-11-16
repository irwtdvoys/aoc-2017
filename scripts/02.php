<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Checksum;

	$helper = new Checksum(2);
	$helper->run()->output();

	// Part 1: 43074
	// Part 2: 280
?>
