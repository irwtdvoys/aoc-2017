<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Dancing\Move;
	use App\Dancing\Moves;
	use Exception;

	class Dancing extends Helper
	{
		/** @var Move[] */
		private array $moves;
		/** @var string[] */
		private array $programs;
		/** @var string[] */
		private array $cache = array();

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$raw = parent::load($override);

			$moves = explode(",", $raw);

			foreach ($moves as $move)
			{
				$this->moves[] = new Move($move);
			}

			$this->programs = array();

			for ($index = 0; $index < 16; $index++)
			{
				$this->programs[] = chr(97 + $index);
			}
		}

		private function swap(int $a, int $b): void
		{
			$tmp = $this->programs[$a];
			$this->programs[$a] = $this->programs[$b];
			$this->programs[$b] = $tmp;
		}

		private function process(Move $move): void
		{
			switch ($move->type)
			{
				case Moves::SPIN:

					// faster than array_pop and array_unshift
					$offset = 0 - $move->parameters[0];

					$head = array_slice($this->programs, 0, $offset);
					$tail = array_slice($this->programs, $offset);

					$this->programs = array_merge($tail, $head);

					break;
				case Moves::EXCHANGE:

					$this->swap($move->parameters[0], $move->parameters[1]);

					break;
				case Moves::PARTNER:

					// faster than searching the array for the values
					$tmp = array_flip($this->programs);

					$a = $tmp[$move->parameters[0]];
					$b = $tmp[$move->parameters[1]];

					$this->swap($a, $b);

					break;
				default:
					throw new Exception("Unknown move type '" . $move->type . "'");
					break;
			}
		}

		public function output(): string
		{
			return implode("", $this->programs);
		}

		public function run(): Result
		{
			$count = 0;
			$target = 1000000000;

			$result = new Result();

			while ($count < $target)
			{
				echo($count . "\r");

				foreach ($this->moves as $move)
				{
					$this->process($move);
				}

				$current = $this->output();


				if (in_array($current, $this->cache))
				{
					break;
				}

				$this->cache[] = $current;


				if ($count === 0)
				{
					$result->part1 = $this->output();
				}

				$count++;
			}

			$result->part2 = $this->cache[($target % $count) - 1];

			return $result;
		}
	}
?>
