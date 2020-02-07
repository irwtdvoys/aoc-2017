<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;

	class Stream extends Helper
	{
		public array $data;

		public function __construct(int $day)
		{
			parent::__construct($day);

			$this->data = str_split(parent::load(), 1);
		}

		public function run(): Result
		{
			$count = count($this->data);

			$index = 0;
			$depth = 0;
			$garbage = false;
			$groups = 0;
			$score = 0;
			$length = 0;

			while ($index < $count)
			{
				$next = $this->data[$index];

				switch ($next)
				{
					case "!":
						$index++;
						break;
					case "{":
						if (!$garbage)
						{
							$depth++;
							$groups++;
							$score += $depth;
						}
						else
						{
							$length++;
						}
						break;
					case "}":
						if (!$garbage)
						{
							$depth--;
						}
						else
						{
							$length++;
						}
						break;
					case "<":
						if ($garbage)
						{
							$length++;
						}

						$garbage = true;
						break;
					case ">":
						$garbage = false;
						break;
					default:
						if ($garbage)
						{
							$length++;
						}
						break;
				}

				$index++;
			}


			return new Result($score, $length);
		}
	}
?>
