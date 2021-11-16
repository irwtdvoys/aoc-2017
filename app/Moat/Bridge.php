<?php
	namespace App\Moat;

	class Bridge
	{
		/** @var Component[] $components */
		public array $components = [];

		public function add(Component $component)
		{
			$this->components[] = $component;
		}

		public function strength(): int
		{
			return array_sum(
				array_map(
					function($element)
					{
						return $element->strength();
					},
					$this->components
				)
			);
		}

		public function length(): int
		{
			return count($this->components);
		}

		public function output(): void
		{
			$components = [];

			foreach ($this->components as $component)
			{
				$components[] = (string)$component;
			}

			echo(implode("--", $components) . PHP_EOL);
		}
	}
?>
