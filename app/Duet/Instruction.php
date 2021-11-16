<?php
	namespace App\Duet;

	class Instruction
	{
		public string $type;
		public array $parameters;

		public function __construct(string $type, array $parameters)
		{
			$this->type = $type;

			foreach ($parameters as &$parameter)
			{
				$parameter = ($parameter === (string)(int)$parameter) ? (int)$parameter : $parameter;
			}

			$this->parameters = $parameters;
		}

		public function __toString()
		{
			return implode(" ", array_merge(array($this->type), $this->parameters));
		}
	}
?>
