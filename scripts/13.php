<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Firewall;

	$helper = new Firewall(13);
	$helper->run()->output();

	// Part 1: 3184
	// Part 2: 3878062
?>
