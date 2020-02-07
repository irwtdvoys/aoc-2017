<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Utils\HexDirections as Directions;
	use App\Utils\Position3d;

	class HexGrid extends Helper
	{
		public Position3d $position;
		public array $path;

		public function __construct(int $day)
		{
			parent::__construct($day);

			$this->position = new Position3d();
			$this->path = explode(",", parent::load());
		}

		public function move(string $direction)
		{
			switch ($direction)
			{
				case Directions::NORTH:
					$this->position->y++;
					$this->position->z--;
					break;
				case Directions::NORTH_EAST:
					$this->position->x++;
					$this->position->z--;
					break;
				case Directions::SOUTH_EAST:
					$this->position->x++;
					$this->position->y--;
					break;
				case Directions::SOUTH:
					$this->position->y--;
					$this->position->z++;
					break;
				case Directions::SOUTH_WEST:
					$this->position->x--;
					$this->position->z++;
					break;
				case Directions::NORTH_WEST:
					$this->position->x--;
					$this->position->y++;
					break;
			}
		}

		public function distance(Position3d $from = null, Position3d $to = null)
		{
			if ($from === null)
			{
				$from = new Position3d();
			}

			if ($to === null)
			{
				$to = $this->position;
			}

			return max(abs($from->x - $to->x), abs($from->y - $to->y), abs($from->z - $to->z));
		}

		public function run(): Result
		{
			$max = 0;

			foreach ($this->path as $next)
			{
				$this->move($next);
				$max = max($max, $this->distance());
			}

			return new Result($this->distance(), $max);
		}
	}
?>
