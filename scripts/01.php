<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Captcha;

	$helper = new Captcha(1);
	$helper->run()->output();

	// Part 1: 1253
	// Part 2: 1278
?>
