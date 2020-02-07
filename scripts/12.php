<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Pipes;

	$helper = new Pipes(12);
	$helper->run()->output();

	// Part 1: 288
	// Part 2: 211
?>
