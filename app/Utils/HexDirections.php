<?php
	namespace App\Utils;

	use Bolt\Enum;

	class HexDirections extends Enum
	{
		const NORTH = "n";
		const NORTH_EAST = "ne";
		const SOUTH_EAST = "se";
		const SOUTH = "s";
		const SOUTH_WEST = "sw";
		const NORTH_WEST = "nw";
	}
?>
