<?php
	namespace App\Firewall;

	use App\Utils\ArrowDirections as Directions;

	class Layer
	{
		public int $depth;
		public int $range;
		public int $position;
		public string $direction;

		public function __construct(int $depth, int $range)
		{
			$this->depth = $depth;
			$this->range = $range;
			$this->reset();
		}

		public function reset(): void
		{
			$this->position = 0;
			$this->direction = Directions::UP;
		}

		public function step(): void
		{
			switch ($this->direction)
			{
				case Directions::UP:

					$this->position++;

					if ($this->position === ($this->range - 1))
					{
						$this->direction = Directions::DOWN;
					}

					break;
				case Directions::DOWN:

					$this->position--;

					if ($this->position === 0)
					{
						$this->direction = Directions::UP;
					}

					break;
			}
		}

		public function severity(): int
		{
			return $this->depth * $this->range;
		}
	}
?>
