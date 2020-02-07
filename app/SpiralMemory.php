<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Utils\ArrowDirections as Direction;

	class SpiralMemory extends Helper
	{
		public int $target;
		public array $memory = [[]];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->target = parent::load($override);
		}

		private function count(int $x, int $y)
		{
			$count = 0;

			for ($xDiff = -1; $xDiff <= 1; $xDiff++)
			{
				for ($yDiff = -1; $yDiff <= 1; $yDiff++)
				{
					if (isset($this->memory[$x + $xDiff][$y + $yDiff]))
					{
						$count += $this->memory[$x + $xDiff][$y + $yDiff];
					}
				}
			}

			return $count;
		}

		public function run(): Result
		{
			$result = new Result();

			$x = 0;
			$y = 0;

			$count = 1;
			$direction = Direction::DOWN;

			while ($count <= $this->target)
			{
				$this->memory[$x][$y] = ($x === 0 && $y === 0) ? 1 : $this->count($x, $y);

				if ($this->memory[$x][$y] > $this->target && !isset($result->part2))
				{
					$result->part2 = $this->memory[$x][$y];
				}

				if ($count !== $this->target)
				{
					switch ($direction)
					{
						case Direction::UP:
							$y++;

							if (!isset($this->memory[$x - 1][$y]))
							{
								$direction = Direction::LEFT;
							}

							break;
						case Direction::DOWN:
							$y--;

							if (!isset($this->memory[$x + 1][$y]))
							{
								$direction = Direction::RIGHT;
							}

							break;
						case Direction::LEFT:
							$x--;

							if (!isset($this->memory[$x][$y - 1]))
							{
								$direction = Direction::DOWN;
							}

							break;
						case Direction::RIGHT:
							$x++;

							if (!isset($this->memory[$x][$y + 1]))
							{
								$direction = Direction::UP;
							}

							break;
					}
				}

				$count++;
			}

			$result->part1 = abs($x) + abs($y);

			#$this->draw();

			return $result;
		}

		public function draw()
		{
			for ($x = 2; $x >= -2; $x--)
			{
				for ($y = 2; $y >= -2; $y--)
				{
					echo($this->memory[$x][$y] . " ");
				}

				echo(PHP_EOL);
			}
		}
	}
?>
