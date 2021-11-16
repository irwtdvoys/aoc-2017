<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Duet\Instruction;
	use App\Coprocessor\Program;

	class Coprocessor extends Helper
	{
		public Program $program;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$instructions = explode(PHP_EOL, parent::load($override));

			foreach ($instructions as &$instruction)
			{
				$parts = explode(" ", $instruction);

				$instruction = new Instruction(array_shift($parts), $parts);
			}

			$this->program = new Program($instructions);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);
			$count = 0;

			while (!$this->program->terminated)
			{
				$this->program->step();

				$count++;
			}

			$result->part1 = $this->program->count;

			$h = 0;
			for ($b = 109300; $b <= 126300; $b += 17) {
				for ($e = 2; $e * $e <= $b; $e++) {
					if ($b % $e == 0) {
						$h++;
						break;
					}
				}
			}

			$result->part2 = $h;

			return $result;
		}
	}
?>
