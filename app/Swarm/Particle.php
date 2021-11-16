<?php
	namespace App\Swarm;

	use App\Utils\Position3d;

	class Particle
	{
		public Position3d $position;
		public Position3d $velocity;
		public Position3d $acceleration;

		public bool $removed = false;

		public function distance(): int
		{
			return $this->position->energy();
		}

		public function isStopped(): bool
		{
			return $this->acceleration->energy() === 0;
		}

		public function accelerate(): void
		{
			$this->velocity->x += $this->acceleration->x;
			$this->velocity->y += $this->acceleration->y;
			$this->velocity->z += $this->acceleration->z;
		}

		public function move(): void
		{
			$this->position->x += $this->velocity->x;
			$this->position->y += $this->velocity->y;
			$this->position->z += $this->velocity->z;
		}
	}
?>
