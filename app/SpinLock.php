<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\CircularLinkedList as LinkedList;

	class SpinLock extends Helper
	{
		public LinkedList $list;
		public int $step;

		public function __construct(int $day, int $override = null)
		{
			parent::__construct($day);

			$this->list = new LinkedList(5);
			$this->step = isset($override) ? $override : (int)parent::load();
		}

		public function run(): Result
		{
			$result = new Result();

			$index = 0;

			for ($loop = 1; $loop <= 50000000; $loop++)
			{
				$index = ($index + $this->step + 1) % $loop;

				if ($loop <= 2017)
				{
					$this->list->forward($this->step);
					$this->list->insert($loop);

					$result->part1 = $this->list->current->next->data;
				}
				else
				{
					if ($index === 0)
					{
						$result->part2 = $loop;
					}
				}
			}

			return $result;
		}
	}
?>
