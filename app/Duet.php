<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Duet\Instruction;
	use App\Duet\Program;

	class Duet extends Helper
	{
		/** @var Program[] */
		private array $programs;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$instructions = explode(PHP_EOL, parent::load($override));

			foreach ($instructions as &$instruction)
			{
				$parts = explode(" ", $instruction);

				$instruction = new Instruction(array_shift($parts), $parts);
			}

			$this->programs[] = new Program(0, $instructions);
			$this->programs[] = new Program(1, $instructions);
		}

		private function isDeadlocked(): bool
		{
			return ($this->programs[0]->isWaiting() && $this->programs[1]->isWaiting()) ? true : false;
		}

		public function run(): Result
		{
			$count = 0;

			$aocResult = new Result(3188, 0);

			while (true)
			{
				for ($index = 0; $index < 2; $index++)
				{
					$program = $this->programs[$index];

					if ($program->terminated)
					{
						echo("Program " . $index . " is terminated" . PHP_EOL);
						continue;
					}

					// process program
					while (!$program->isWaiting())
					{
						$result = $program->step();

						if ($result !== null)
						{
							if ($index === 1)
							{
								$aocResult->part2++;
							}

							// add to other program queue
							$this->programs[$index === 0 ? 1 : 0]->received[] = $result;
						}
					}
				}

				if ($this->isDeadlocked())
				{
					break;
				}

				$count++;
			}
			return $aocResult;
		}
	}
?>
