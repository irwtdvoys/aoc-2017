<?php
	namespace App\Pipes;

	class Program
	{
		public int $name;
		/** @var Program[] */
		public array $connections;

		public function __construct(int $name)
		{
			$this->name = $name;
			$this->connections = array();
		}

		public function link(Program $program)
		{
			$this->connections[] = $program;
		}
	}
?>
