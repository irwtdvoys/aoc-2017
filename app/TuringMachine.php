<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\LinkedList\Node;

	class TuringMachine extends Helper
	{
		private ?Node $current;
		private ?Node $first;
		private ?Node $last;

		private string $state = "A";

		public function __construct(int $day)
		{
			parent::__construct($day);

			$this->current = new Node(0);
			$this->first = $this->current;
			$this->last = $this->current;
		}

		private function moveLeft(): void
		{
			if ($this->current->previous === null)
			{
				$this->current->previous = new Node(0, null, $this->current);
				$this->first = $this->current->previous;
			}

			$this->current = $this->current->previous;
		}

		private function moveRight(): void
		{
			if ($this->current->next === null)
			{
				$this->current->next = new Node(0, $this->current, null);
				$this->last = $this->current->next;
			}

			$this->current = $this->current->next;
		}

		private function processExample(): void
		{
			switch ($this->state)
			{
				case "A":
					if ($this->current->data === 0)
					{
						$this->current->data = 1;
						$this->moveRight();
					}
					else
					{
						$this->current->data = 0;
						$this->moveLeft();
					}

					$this->state = "B";
					break;
				case "B":
					if ($this->current->data === 0)
					{
						$this->current->data = 1;
						$this->moveLeft();
					}
					else
					{
						$this->current->data = 1;
						$this->moveRight();
					}

					$this->state = "A";
					break;
			}
		}

		private function process(): void
		{
			switch ($this->state)
			{
				case "A":
					if ($this->current->data === 0)
					{
						$this->current->data = 1;
						$this->moveRight();
						$this->state = "B";
					}
					else
					{
						$this->current->data = 0;
						$this->moveLeft();
						$this->state = "C";
					}
					break;
				case "B":
					if ($this->current->data === 0)
					{
						$this->current->data = 1;
						$this->moveLeft();
						$this->state = "A";
					}
					else
					{
						$this->current->data = 1;
						$this->moveRight();
						$this->state = "D";
					}
					break;
				case "C":
					if ($this->current->data === 0)
					{
						$this->current->data = 0;
						$this->moveLeft();
						$this->state = "B";
					}
					else
					{
						$this->current->data = 0;
						$this->moveLeft();
						$this->state = "E";
					}
					break;
				case "D":
					if ($this->current->data === 0)
					{
						$this->current->data = 1;
						$this->moveRight();
						$this->state = "A";
					}
					else
					{
						$this->current->data = 0;
						$this->moveRight();
						$this->state = "B";
					}
					break;
				case "E":
					if ($this->current->data === 0)
					{
						$this->current->data = 1;
						$this->moveLeft();
						$this->state = "F";
					}
					else
					{
						$this->current->data = 1;
						$this->moveLeft();
						$this->state = "C";
					}
					break;
				case "F":
					if ($this->current->data === 0)
					{
						$this->current->data = 1;
						$this->moveRight();
						$this->state = "D";
					}
					else
					{
						$this->current->data = 1;
						$this->moveRight();
						$this->state = "A";
					}
					break;
			}
		}

		private function count(): int
		{
			$pointer = $this->first;
			$count = 0;

			while (true)
			{
				if ($pointer->data === 1)
				{
					$count++;
				}

				if ($pointer->next === null)
				{
					break;
				}

				$pointer = $pointer->next;
			}

			return $count;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$iteration = 0;

			while ($iteration < 12481997)
			{
				$this->process();//Example();
				$iteration++;
			}

			$result->part1 = $this->count();

			return $result;
		}
	}
?>
