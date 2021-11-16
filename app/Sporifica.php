<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Sporifica\Bot;
	use App\Sporifica\Tiles;
	use App\Utils\Colours;

	class Sporifica extends Helper
	{
		/** @var bool[][] */
		public array $map;
		public int $infections = 0;
		public Bot $carrier;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->carrier = new Bot();

			$width = 10001;
			$size = ($width - 1) / 2;
			$keys = range(-$size, $size);

			$row = array_fill_keys($keys, Tiles::CLEAN);
			$this->map = array_fill_keys($keys, $row);

			$rows = explode(PHP_EOL, parent::load($override));
			$map = array_map(
				function($row)
				{
					return str_split($row);
				},
				$rows
			);

			$yOffset = (count($map) - 1) / 2;
			$xOffset = (count($map[0]) - 1) / 2;

			for ($y = 0; $y < count($map); $y++)
			{
				for ($x = 0; $x < count($map[0]); $x++)
				{
					$this->map[$y - $yOffset][$x - $xOffset] = $map[$y][$x];
				}
			}
		}

		public function output()
		{
			foreach ($this->map as $y => $row)
			{
				foreach ($row as $x => $node)
				{
					$value = $node;

					if ($x === $this->carrier->position->x && $y === $this->carrier->position->y)
					{
						$value = Colours::colour($value, Colours::BLUE);
					}

					echo($value);
				}

				echo(PHP_EOL);
			}

			echo(PHP_EOL);
		}

		public function isCurrentlyInfected(): bool
		{
			return $this->getCurrent() === Tiles::INFECTED;
		}

		public function burst()
		{
			$turn = $this->isCurrentlyInfected() ? "right" : "left";
			$this->carrier->$turn();

			if ($this->getCurrent() === Tiles::INFECTED)
			{
				$this->setCurrent(Tiles::CLEAN);
			}
			else
			{
				$this->setCurrent(Tiles::INFECTED);
				$this->infections++;
			}

			$this->carrier->move();
		}

		public function getCurrent(): string
		{
			return $this->map[$this->carrier->position->y][$this->carrier->position->x];
		}

		public function setCurrent(string $tile): void
		{
			$this->map[$this->carrier->position->y][$this->carrier->position->x] = $tile;
		}

		public function burst2()
		{
			switch ($this->getCurrent())
			{
				case Tiles::CLEAN:
					$this->carrier->left();
					$this->setCurrent(Tiles::WEAKENED);
					break;
				case Tiles::WEAKENED:
					$this->setCurrent(Tiles::INFECTED);
					$this->infections++;
					break;
				case Tiles::INFECTED:
					$this->carrier->right();
					$this->setCurrent(Tiles::FLAGGED);
					break;
				case Tiles::FLAGGED:
					$this->carrier->right();
					$this->carrier->right();
					$this->setCurrent(Tiles::CLEAN);
					break;
			}

			$this->carrier->move();
		}

		public function run(): Result
		{
			#$this->output();
			$result = new Result(0, 0);

			$bursts = 10000;

			for ($loop = 0; $loop < $bursts; $loop++)
			{
				#echo(number_format($loop) . "\r");
				$this->burst();
			}

			$result->part1 = $this->infections;

			$bursts = 10000000;
			$this->infections = 0;

			for ($loop = 0; $loop < $bursts; $loop++)
			{
				#echo(number_format($loop) . "\r");
				$this->burst2();
			}

			#$this->output();
			$result->part2 = $this->infections;


			return $result;
		}
	}
?>
