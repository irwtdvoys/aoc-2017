<?php
	namespace App\Coprocessor;

	use App\Duet\Instruction;

	class Program
	{
		/** @var int[] */
		public array $registers = array();
		/** @var Instruction[] */
		private array $instructions;

		public int $pointer = 0;
		public bool $terminated = false;

		public int $count = 0;

		public function __construct($instructions)
		{
			$this->instructions = $instructions;
			$this->registers = [
				"a" => 0,
				"b" => 0,
				"c" => 0,
				"d" => 0,
				"e" => 0,
				"f" => 0,
				"g" => 0,
				"h" => 0
			];
		}

		private function getValue($parameter): int
		{
			if (is_int($parameter))
			{
				return $parameter;
			}

			return $this->registers[$parameter];
		}

		public function step()
		{
			if ($this->pointer < 0 || $this->pointer >= count($this->instructions))
			{
				$this->terminated = true;
				return;
			}

			$instruction = $this->instructions[$this->pointer];

			switch ($instruction->type)
			{
				case Codes::SET:
					$this->registers[$instruction->parameters[0]] = $this->getValue($instruction->parameters[1]);
					$this->pointer++;
					break;
				case Codes::SUB:
					$this->registers[$instruction->parameters[0]] -= $this->getValue($instruction->parameters[1]);
					$this->pointer++;
					break;
				case Codes::MULTIPLY:
					$this->registers[$instruction->parameters[0]] *= $this->getValue($instruction->parameters[1]);
					$this->pointer++;
					$this->count++;
					break;
				case Codes::JUMP:

					if ($this->getValue($instruction->parameters[0]) !== 0)
					{
						$this->pointer += $this->getValue($instruction->parameters[1]);
					}
					else
					{
						$this->pointer++;
					}

					break;
				default:
					die("UNKNOWN INSTRUCTION");
					break;
			}
		}
	}
?>
