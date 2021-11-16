<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Utils\ArrowDirections as Directions;
	use App\Utils\Colours;
	use App\Utils\Position2d;
	use Bolt\Files;
	use Exception;

	class Tubes extends Helper
	{
		/** @var string[][] */
		private array $data;

		public Position2d $position;
		public string $direction = Directions::DOWN;
		public string $path = "";

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->data = array(
				array()
			);

			$raw = (new Files())->load($this->filename($override));

			$lines = explode(PHP_EOL, $raw);

			$y = 0;

			foreach ($lines as $line)
			{
				if ($line !== "")
				{
					$line = str_split($line);

					$x = 0;

					foreach ($line as $item)
					{
						$this->data[$x][$y] = $item;

						if ($y === 0 && $item === "|")
						{
							$this->position = new Position2d($x, $y);
							$this->direction = Directions::DOWN;
						}

						$x++;
					}
				}

				$y++;
			}
		}

		public function output()
		{
			for ($y = 0; $y < count($this->data[0]); $y++)
			{
				for ($x = 0; $x < count($this->data); $x++)
				{
					if ($x === $this->position->x && $y === $this->position->y)
					{
						echo(Colours::colour($this->data[$x][$y], Colours::RED));
					}
					else
					{
						echo($this->data[$x][$y]);
					}
				}

				echo(PHP_EOL);
			}

			echo(PHP_EOL);
		}

		private function move()
		{
			switch ($this->direction)
			{
				case Directions::UP:
					$this->position->y--;
					break;
				case Directions::RIGHT:
					$this->position->x++;
					break;
				case Directions::DOWN:
					$this->position->y++;
					break;
				case Directions::LEFT:
					$this->position->x--;
					break;
			}

			$value = $this->data[$this->position->x][$this->position->y];

			if ($value === " ")
			{
				throw new \Exception("END?");
			}
			elseif ($value === "+")
			{
				$this->turn();
			}
			elseif (!in_array($value, array("-", "|", " ")))
			{
				$this->path .= $value;
			}
		}

		private function turn(): void
		{
			$x = $this->position->x;
			$y = $this->position->y;

			switch ($this->direction)
			{
				case Directions::UP:
					// left
					if ($this->data[$x - 1][$y] !== " ")
					{
						$this->direction = Directions::LEFT;
					}
					// right
					elseif ($this->data[$x + 1][$y] !== " ")
					{
						$this->direction = Directions::RIGHT;
					}
					break;
				case Directions::RIGHT:
					// left
					if ($this->data[$x][$y - 1] !== " ")
					{
						$this->direction = Directions::UP;
					}
					// right
					elseif ($this->data[$x][$y + 1] !== " ")
					{
						$this->direction = Directions::DOWN;
					}
					break;
				case Directions::DOWN:
					// left
					if ($this->data[$x + 1][$y] !== " ")
					{
						$this->direction = Directions::RIGHT;
					}
					// right
					elseif ($this->data[$x - 1][$y] !== " ")
					{
						$this->direction = Directions::LEFT;
					}
					break;
				case Directions::LEFT:
					// left
					if ($this->data[$x][$y + 1] !== " ")
					{
						$this->direction = Directions::DOWN;
					}
					// right
					elseif ($this->data[$x][$y - 1] !== " ")
					{
						$this->direction = Directions::UP;
					}
					break;
			}
		}

		public function run(): Result
		{
			$count = 1;

			while (true)
			{
				try
				{
					$this->move();
				}
				catch (Exception $exception)
				{
					break;
				}

				$count++;
			}

			return new Result($this->path, $count);
		}
	}
?>
