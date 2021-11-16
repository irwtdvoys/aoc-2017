<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\TuringMachine;

	$helper = new TuringMachine(25);
	$helper->run()->output();

	// Part 1: 3362
	// Part 2:
?>
