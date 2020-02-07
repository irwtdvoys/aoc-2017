<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;

	class Captcha extends Helper
	{
		public function run(): Result
		{
			$result = new Result(0, 0);
			$data = parent::load();

			$length = strlen($data);
			$half = $length / 2;

			for ($index = 0; $index < $length; $index++)
			{
				$current = (int)$data[$index];

				$target = ($index + $half) % $length;

				$next1 = ($index === $length - 1) ? (int)$data[0] : (int)$data[$index + 1];
				$next2 = (int)$data[$target];

				if ($current === $next1)
				{
					$result->part1 += $next1;
				}

				if ($current === $next2)
				{
					$result->part2 += $next2;
				}
			}

			return $result;
		}
	}
?>
