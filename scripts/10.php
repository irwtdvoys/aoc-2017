<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Hash;

	$helper = new Hash(10);
	$helper->run()->output();

	// Part 1: 62238
	// Part 2: 2b0c9cc0449507a0db3babd57ad9e8d8
?>
