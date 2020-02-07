<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use Bolt\Dsv;

	class Checksum extends Helper
	{
		/** @var array[] */
		public array $data;

		public function __construct(int $day)
		{
			parent::__construct($day);

			$dsv = new Dsv("\t");
			$dsv->load(parent::filename(), true);

			$this->data = $dsv->data;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			foreach ($this->data as $row)
			{
				$min = PHP_INT_MAX;
				$max = 0;

				foreach ($row as $item)
				{
					$item = (int)$item;

					$min = min($min, $item);
					$max = max($max, $item);
				}

				$diff = $max - $min;

				$result->part1 += $diff;

				rsort($row);

				for ($index = 0; $index < count($row) - 1; $index++)
				{
					$item = (int)$row[$index];

					for ($loop = $index + 1; $loop < count($row); $loop++)
					{
						$next = (int)$row[$loop];

						if ($item % $next === 0)
						{
							$result->part2 += ($item / $next);
							break;
						}
					}
				}
			}

			return $result;
		}
	}
?>
