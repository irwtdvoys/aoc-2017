<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Registers\Comparators;
	use App\Registers\Condition;
	use App\Registers\Instruction;
	use Exception;

	class Registers extends Helper
	{
		/** @var int[]  */
		private array $registers;

		private array $instructions;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->loadData($override);
		}

		public function loadData(string $override = null)
		{
			$data = parent::load($override);

			$pattern = "/(?'register'[a-z]+) (?'method'inc|dec) (?'value'[0-9-]+) if (?'creg'[a-z]+) (?'ccomp'[><=!]+) (?'cval'[0-9-]+)/";

			preg_match_all($pattern, $data, $matches);

			$this->registers = array();

			for ($index = 0; $index < count($matches[0]); $index++)
			{
				$this->registers[$matches['register'][$index]] = 0;
				$this->registers[$matches['creg'][$index]] = 0;

				$this->instructions[] = new Instruction(array(
					"register" => $matches['register'][$index],
					"method" => $matches['method'][$index],
					"value" => (int)$matches['value'][$index],
					"condition" => array(
						"register" => $matches['creg'][$index],
						"comparator" => $matches['ccomp'][$index],
						"value" => (int)$matches['cval'][$index]
					)
				));
			}

			#dump($this->instructions);
		}

		private function check(Condition $condition): bool
		{
			$result = false;

			switch ($condition->comparator)
			{
				case Comparators::EQUAL_TO:

					if ($this->registers[$condition->register] === $condition->value)
					{
						$result = true;
					}

					break;
				case Comparators::LESS_THAN:

					if ($this->registers[$condition->register] < $condition->value)
					{
						$result = true;
					}

					break;
				case Comparators::GREATER_THAN:

					if ($this->registers[$condition->register] > $condition->value)
					{
						$result = true;
					}

					break;
				case Comparators::NOT_EQUAL_TO:

					if ($this->registers[$condition->register] !== $condition->value)
					{
						$result = true;
					}

					break;
				case Comparators::LESS_THAN_OR_EQUAL_TO:

					if ($this->registers[$condition->register] <= $condition->value)
					{
						$result = true;
					}

					break;
				case Comparators::GREATER_THAN_OR_EQUAL_TO:

					if ($this->registers[$condition->register] >= $condition->value)
					{
						$result = true;
					}

					break;
				default:
					throw new Exception("Unknown comparator");
					break;
			}

			return $result;
		}

		public function process(Instruction $instruction)
		{
			switch ($instruction->method)
			{
				case "inc":
					$this->registers[$instruction->register] += $instruction->value;
					break;
				case "dec":
					$this->registers[$instruction->register] -= $instruction->value;
					break;
				default:
					throw new Exception("Unknown instruction method");
					break;
			}
		}

		public function run(): Result
		{
			$max = 0;

			foreach ($this->instructions as $instruction)
			{
				if ($this->check($instruction->condition) === true)
				{
					$this->process($instruction);
				}

				$max = max($max, max($this->registers));
			}


			return new Result(max($this->registers), $max);
		}
	}
?>
