<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Swarm\Particle;
	use App\Utils\Position3d;

	class Swarm extends Helper
	{
		/** @var Particle[] */
		public array $particles = array();

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$tmp = parent::load($override);

			preg_match_all("/<(?'coords'[0-9-,]+)>/", $tmp, $matches);

			$rows = array_chunk($matches['coords'], 3);

			foreach ($rows as $row)
			{
				$particle = new Particle();
				$particle->position = $this->toPosition($row[0]);
				$particle->velocity = $this->toPosition($row[1]);
				$particle->acceleration = $this->toPosition($row[2]);

				$this->particles[] = $particle;
			}
		}

		private function collisions()
		{
			foreach ($this->particles as &$particle)
			{
				// skip removed particles
				if ($particle->removed === true)
				{
					continue;
				}

				foreach ($this->particles as &$next)
				{
					// skip self + removed particles
					if ($particle === $next || $next->removed === true)
					{
						continue;
					}

					if ($particle->position->x === $next->position->x && $particle->position->y === $next->position->y && $particle->position->z === $next->position->z)
					{
						$particle->removed = true;
						$next->removed = true;
					}
				}
			}
		}

		private function removed(): int
		{
			$count = 0;

			foreach ($this->particles as $particle)
			{
				if ($particle->removed === true)
				{
					$count++;
				}
			}

			return $count;
		}

		private function toPosition(string $data)
		{
			list($x, $y, $z) = explode(",", $data);

			return new Position3d((int)$x, (int)$y, (int)$z);
		}

		public function run(): Result
		{
			$count = 0;

			$closest = (object)array(
				"index" => null,
				"count" => 0
			);

			while ($count < 1000)
			{
				$distances = array();

				for ($index = 0; $index < count($this->particles); $index++)
				{
					$particle = $this->particles[$index];

					$particle->accelerate();
					$particle->move();

					$distances[$index] = $particle->distance();
				}

				$this->collisions();

				$closestIndex = array_keys($distances, min($distances))[0];

				if ($closest->index === $closestIndex)
				{
					$closest->count++;
				}
				else
				{
					$closest->index = $closestIndex;
					$closest->count = 0;
				}

				if ($closest->count > 1000)
				{
					break;
				}

				$count++;
			}

			return new Result($closest->index, count($this->particles) - $this->removed());
		}
	}
?>
