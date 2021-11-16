<?php
	namespace App\Moat;

	class Component
	{
		/** @var int[] $ports */
		public array $ports;

		public function __construct(string $data)
		{
			$this->ports = array_map("intval", explode("/", $data));
		}

		public function connectable(int $pins): bool
		{
			return in_array($pins, $this->ports);
		}

		public function other(int $pins): int
		{
			return $this->ports[0] === $pins ? $this->ports[1] : $this->ports[0];
		}

		public function strength(): int
		{
			return array_sum($this->ports);
		}

		public function __toString(): string
		{
			return implode("/", $this->ports);
		}
	}
?>
