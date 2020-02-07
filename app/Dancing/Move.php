<?php
	namespace App\Dancing;

	class Move
	{
		public string $type;
		public array $parameters;

		public function __construct(string $move)
		{
			$this->type = $move[0];
			$this->parameters = explode("/", substr($move, 1));
		}
	}
?>
