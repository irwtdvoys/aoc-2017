<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Dancing;

	$helper = new Dancing(16);
	$helper->run()->output();

	// Part 1: pkgnhomelfdibjac
	// Part 2: pogbjfihclkemadn
?>
