<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;

	class Jumps extends Helper
	{
		private array $data;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->data = array_map(
				function($element)
				{
					return (int)$element;
				},
				explode(PHP_EOL, parent::load($override))
			);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$data = $this->data;
			$cursor = 0;

			while (isset($data[$cursor]))
			{
				$offset = $data[$cursor];
				$data[$cursor]++;
				$cursor += $offset;

				$result->part1++;
			}

			$data = $this->data;
			$cursor = 0;

			while (isset($data[$cursor]))
			{
				$offset = $data[$cursor];

				if ($offset >= 3)
				{
					$data[$cursor]--;
				}
				else
				{
					$data[$cursor]++;
				}

				$cursor += $offset;

				$result->part2++;
			}

			return $result;
		}
	}
?>
