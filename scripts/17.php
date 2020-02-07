<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\SpinLock;

	$helper = new SpinLock(17);
	$helper->run()->output();

	// Part 1: 1487
	// Part 2: 25674054
?>
