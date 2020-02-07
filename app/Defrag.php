<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Utils\Position2d;

	class Defrag extends Helper
	{
		private Hash $knothash;
		/** @var bool[] */
		private array $grid = [[]];
		/** @var int[] */
		private array $map = [[]];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->knothash = new Hash($day, null, false);
		}

		private function hex2bin($string): string
		{
			return str_pad(base_convert($string, 16, 2), 4, "0", STR_PAD_LEFT);
		}

		private function initialise(): void
		{
			$raw = parent::load();

			for ($y = 0; $y < 128; $y++)
			{
				$hash = $this->knothash->generateHash($raw . "-" . $y);

				$split = str_split($hash);

				$binary = "";

				foreach ($split as $next)
				{
					$binary .= $this->hex2bin($next);
				}

				$split = str_split($binary);

				for ($x = 0; $x < 128; $x++)
				{
					$this->grid[$x][$y] = ($split[$x] === "1") ? true : false;
					$this->map[$x][$y] = null;
				}
			}
		}

		private function count(): int
		{
			$count = 0;

			for ($x = 0; $x < 128; $x++)
			{
				for ($y = 0; $y < 128; $y++)
				{
					if ($this->grid[$x][$y] === true)
					{
						$count++;
					}
				}
			}


			return $count;
		}

		private function markRegion(int $region, $x, $y)
		{
			$this->map[$x][$y] = $region;

			$neighbours = array();

			if ($x > 0)
			{
				// add left
				$position = new Position2d($x - 1, $y);

				if ($this->grid[$position->x][$position->y] === true && !isset($this->map[$position->x][$position->y]))
				{
					$neighbours[] = $position;
				}
			}

			if ($x < 127)
			{
				// add right
				$position = new Position2d($x + 1, $y);

				if ($this->grid[$position->x][$position->y] === true && !isset($this->map[$position->x][$position->y]))
				{
					$neighbours[] = $position;
				}
			}

			if ($y > 0)
			{
				// add top
				$position = new Position2d($x, $y - 1);

				if ($this->grid[$position->x][$position->y] === true && !isset($this->map[$position->x][$position->y]))
				{
					$neighbours[] = $position;
				}
			}

			if ($y < 127)
			{
				// add bottom
				$position = new Position2d($x, $y + 1);

				if ($this->grid[$position->x][$position->y] === true && !isset($this->map[$position->x][$position->y]))
				{
					$neighbours[] = $position;
				}
			}

			foreach ($neighbours as $neighbour)
			{
				$this->markRegion($region, $neighbour->x, $neighbour->y);
			}
		}

		private function regions(): int
		{
			$count = 0;

			for ($x = 0; $x < 128; $x++)
			{
				for ($y = 0; $y < 128; $y++)
				{
					if ($this->grid[$x][$y] === true && !isset($this->map[$x][$y]))
					{
						$count++;

						$this->markRegion($count, $x, $y);
					}
				}
			}

			return $count;
		}

		public function run(): Result
		{
			$this->initialise();

			return new Result($this->count(), $this->regions());
		}
	}
?>
