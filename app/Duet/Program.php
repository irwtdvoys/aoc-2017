<?php
	namespace App\Duet;

	class Program
	{
		/** @var int[] */
		public array $received = array();
		/** @var int[] */
		public array $registers = array();
		/** @var Instruction[] */
		private array $instructions;

		public int $pointer = 0;
		public bool $waiting = false;
		public bool $terminated = false;

		public function __construct($id, $instructions)
		{
			$this->instructions = $instructions;

			$this->initialise();

			$this->registers['p'] = $id;
		}

		private function initialise()
		{
			$identifiers = array();

			foreach ($this->instructions as $instruction)
			{
				foreach ($instruction->parameters as $parameter)
				{
					if (!is_numeric($parameter))
					{
						$identifiers[] = $parameter;
					}
				}
			}

			$identifiers = array_unique($identifiers);

			foreach ($identifiers as $identifier)
			{
				$this->registers[$identifier] = 0;
			}
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
			$instruction = $this->instructions[$this->pointer];

			$result = null;

			switch ($instruction->type)
			{
				case Codes::ADD:
					$this->registers[$instruction->parameters[0]] += $this->getValue($instruction->parameters[1]);
					$this->pointer++;
					break;
				case Codes::JUMP:

					if ($this->getValue($instruction->parameters[0]) > 0)
					{
						$this->pointer += $this->getValue($instruction->parameters[1]);
					}
					else
					{
						$this->pointer++;
					}

					break;
				case Codes::MODULO:
					$this->registers[$instruction->parameters[0]] %= $this->getValue($instruction->parameters[1]);
					$this->pointer++;
					break;
				case Codes::MULTIPLY:
					$this->registers[$instruction->parameters[0]] *= $this->getValue($instruction->parameters[1]);
					$this->pointer++;
					break;
				case Codes::RECEIVE:
					if (count($this->received) === 0)
					{
						$this->waiting = true;
					}
					else
					{
						$this->waiting = false;
						$this->registers[$instruction->parameters[0]] = array_shift($this->received);
						$this->pointer++;
					}
					break;
				case Codes::SET:
					$this->registers[$instruction->parameters[0]] = $this->getValue($instruction->parameters[1]);
					$this->pointer++;
					break;
				case Codes::SEND:
					$result = $this->getValue($instruction->parameters[0]);
					$this->pointer++;
					break;
				default:
					die("UNKNOWN INSTRUCTION");
					break;
			}

			if ($this->pointer < 0 || $this->pointer > count($this->instructions))
			{
				$this->terminated = true;
			}

			return $result;
		}

		public function isWaiting()
		{
			return ($this->waiting === true && count($this->received) === 0) ? true : false;
		}
	}
?>
