<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Art\Pattern;

	class Art extends Helper
	{
		private Pattern $art;
		private array $rules = array();

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->reset();

			$rows = explode(PHP_EOL, parent::load($override));

			foreach ($rows as $row)
			{
				list($from, $to) = explode(" => ", $row);

				$this->rules[$from] = $to;
			}
		}

		public function reset()
		{
			$this->art = new Pattern(".#./..#/###");
		}

		private function output(): void
		{
			$this->art->draw();
		}

		private function process(Pattern $pattern): Pattern
		{
			$cache = clone $pattern;

			$encoded = $cache->encode();

			if (isset($this->rules[$encoded]))
			{
				return new Pattern($this->rules[$encoded]);
			}

			$cache->rotate();
			$encoded = $cache->encode();

			if (isset($this->rules[$encoded]))
			{
				return new Pattern($this->rules[$encoded]);
			}

			$cache->rotate();
			$encoded = $cache->encode();

			if (isset($this->rules[$encoded]))
			{
				return new Pattern($this->rules[$encoded]);
			}

			$cache->rotate();
			$encoded = $cache->encode();

			if (isset($this->rules[$encoded]))
			{
				return new Pattern($this->rules[$encoded]);
			}

			$cache->flip(Pattern::FLIP_VERTICAL);
			$encoded = $cache->encode();

			if (isset($this->rules[$encoded]))
			{
				return new Pattern($this->rules[$encoded]);
			}

			$cache->rotate();
			$encoded = $cache->encode();

			if (isset($this->rules[$encoded]))
			{
				return new Pattern($this->rules[$encoded]);
			}

			$cache->rotate();
			$encoded = $cache->encode();

			if (isset($this->rules[$encoded]))
			{
				return new Pattern($this->rules[$encoded]);
			}

			$cache->rotate();
			$encoded = $cache->encode();

			if (isset($this->rules[$encoded]))
			{
				return new Pattern($this->rules[$encoded]);
			}

			$cache->flip(Pattern::FLIP_HORIZONTAL);
			$encoded = $cache->encode();

			if (isset($this->rules[$encoded]))
			{
				return new Pattern($this->rules[$encoded]);
			}

			$cache->rotate();
			$encoded = $cache->encode();

			if (isset($this->rules[$encoded]))
			{
				return new Pattern($this->rules[$encoded]);
			}

			$cache->rotate();
			$encoded = $cache->encode();

			if (isset($this->rules[$encoded]))
			{
				return new Pattern($this->rules[$encoded]);
			}

			$cache->rotate();
			$encoded = $cache->encode();

			if (isset($this->rules[$encoded]))
			{
				return new Pattern($this->rules[$encoded]);
			}

			// todo: check rotates + flips

			// r, r, r, fv, r, r, r, fh, r, r, r

			echo("NO MATCH" . PHP_EOL);
			die();

			return $pattern;
		}

		public function run(): Result
		{
			$this->output();

			$result = new Result();


			$count = 0;

			while ($count < 18)
			{
				$size = $this->art->size();

				#dump($size);

				if ($size % 2 === 0)
				{
					#echo("Divisible by 2" . PHP_EOL);

					if ($size / 2 > 1)
					{
						$data = $this->art->split(2);
						#die("SPLIT REQUIRED");
					}
					else
					{
						$data = array(
							array(
								$this->art
							)
						);
					}
				}
				elseif ($size % 3 === 0)
				{
					#echo("Divisible by 3" . PHP_EOL);

					if ($size / 3 > 1)
					{
						$data = $this->art->split(3);
						#die("SPLIT REQUIRED");
					}
					else
					{
						$data = array(
							array(
								$this->art
							)
						);
					}
				}

				foreach ($data as &$row)
				{
					foreach ($row as &$element)
					{
						$element = $this->process($element);
					}
				}

				$this->art = new Pattern($this->flatten($data));

				#$this->output();
				echo($count . PHP_EOL);

				if ($count === 4)
				{
					$result->part1 = $this->count(true);
				}

				$count++;
			}


			$result->part2 = $this->count(true);

			return $result;
		}

		private function flatten(array $data): array
		{
			$size = count($data);

			$result = array(
				array()
			);

			for ($x1 = 0; $x1 < $size; $x1++)
			{
				for ($y1 = 0; $y1 < $size; $y1++)
				{
					#echo("[$x1,$y1]" . PHP_EOL);

					$size2 = $data[$x1][$y1]->size();

					for ($x2 = 0; $x2 < $size2; $x2++)
					{
						for ($y2 = 0; $y2 < $size2; $y2++)
						{
							#echo("[$x2,$y2]" . PHP_EOL);

							$x = $x2 + ($x1 * $size2);
							$y = $y2 + ($y1 * $size2);

							$result[$x][$y] = $data[$x1][$y1]->art[$x2][$y2];
						}
					}
				}
			}

			return $result;
		}

		public function count(bool $state): int
		{
			$count = 0;

			foreach ($this->art->art as $row)
			{
				foreach ($row as $element)
				{
					if ($element === $state)
					{
						$count++;
					}
				}
			}

			return $count;
		}
	}
?>
