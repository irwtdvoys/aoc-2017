<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Registers;

	$helper = new Registers(8);
	$helper->run()->output();

	// Part 1: 6611
	// Part 2: 6619
?>
