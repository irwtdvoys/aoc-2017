<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;

	class Passphrases extends Helper
	{
		/** @var string[][]  */
		private array $data;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$data = parent::load($override);

			$rows = explode(PHP_EOL, $data);

			foreach ($rows as &$row)
			{
				$row = explode(" ", $row);
			}

			$this->data = $rows;
		}

		private function sortWord(string $word): string
		{
			$characters = str_split($word, 1);
			sort($characters);

			return implode("", $characters);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			foreach ($this->data as $phrase)
			{
				$counts = array_count_values($phrase);

				if (count($counts) === count($phrase))
				{
					$result->part1++;
				}

				$words = array_map(
					function($word)
					{
						return $this->sortWord($word);
					},
					$phrase
				);

				$counts = array_count_values($words);

				if (count($counts) === count($words))
				{
					$result->part2++;
				}
			}

			return $result;
		}
	}
?>
