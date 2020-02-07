<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;

	class Reallocation extends Helper
	{
		/** @var int[] */
		public array $memory;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->memory = array_map(
				function($element)
				{
					return (int)$element;
				},
				explode("\t", parent::load($override))
			);
		}

		private function reallocate()
		{
			$index = $this->largestMemoryLocation();

			$blocks = $this->memory[$index];
			$this->memory[$index] = 0;

			$count = 0;
			$cursor = $index;

			while ($count < $blocks)
			{
				$cursor = ($cursor + 1) % count($this->memory);

				$this->memory[$cursor]++;

				$count++;
			}
		}

		private function largestMemoryLocation(): int
		{
			return array_keys($this->memory, max($this->memory))[0];
		}

		private function hash(): string
		{
			return base64_encode(json_encode($this->memory));
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$count = 0;

			$hashes = array(
				$this->hash()
			);

			while (true)
			{
				$this->reallocate();
				$count++;

				$hash = $this->hash();

				if (in_array($hash, $hashes))
				{
					break;
				}

				$hashes[] = $hash;
			}

			$result->part1 = $count;
			$result->part2 = $count - array_flip($hashes)[$hash];

			return $result;
		}
	}
?>
