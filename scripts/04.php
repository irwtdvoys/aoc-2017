<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Passphrases;

	$helper = new Passphrases(4);
	$helper->run()->output();

	// Part 1: 337
	// Part 2: 231
?>
