<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Tree;

	$helper = new Tree(7);
	$helper->run()->output();

	// Part 1: aapssr
	// Part 2: 1458
?>
