<?php
	namespace App\Sporifica;

	use App\Utils\CharacterDirections as Directions;
	use App\Utils\Position2d;

	class Bot
	{
		public string $direction;
		public Position2d $position;

		public function __construct(int $x = 0, int $y = 0, string $direction = Directions::UP)
		{
			$this->position = new Position2d($x, $y);
			$this->direction = $direction;
		}

		public function right(): void
		{
			switch ($this->direction)
			{
				case Directions::UP:
					$this->direction = Directions::RIGHT;
					break;
				case Directions::RIGHT:
					$this->direction = Directions::DOWN;
					break;
				case Directions::DOWN:
					$this->direction = Directions::LEFT;
					break;
				case Directions::LEFT:
					$this->direction = Directions::UP;
					break;
			}
		}

		public function left(): void
		{
			switch ($this->direction)
			{
				case Directions::UP:
					$this->direction = Directions::LEFT;
					break;
				case Directions::RIGHT:
					$this->direction = Directions::UP;
					break;
				case Directions::DOWN:
					$this->direction = Directions::RIGHT;
					break;
				case Directions::LEFT:
					$this->direction = Directions::DOWN;
					break;
			}
		}

		public function move(): void
		{
			switch ($this->direction)
			{
				case Directions::UP:
					$this->position->y -= 1;
					break;
				case Directions::RIGHT:
					$this->position->x += 1;
					break;
				case Directions::DOWN:
					$this->position->y += 1;
					break;
				case Directions::LEFT:
					$this->position->x -= 1;
					break;
			}
		}
	}
?>
