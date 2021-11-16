<?php
	namespace App\Sporifica;

	use Bolt\Enum;

	class Tiles extends Enum
	{
		const INFECTED = "#";
		const CLEAN = ".";
		const WEAKENED = "W";
		const FLAGGED = "F";
	}
?>
