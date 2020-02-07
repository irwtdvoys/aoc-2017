<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Firewall\Layer;

	class Firewall extends Helper
	{
		/** @var Layer[] */
		private array $layers;
		private int $count;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$rows = explode(PHP_EOL, parent::load($override));

			foreach ($rows as $row)
			{
				list($depth, $range) = explode(": ", $row);

				$this->layers[(int)$depth] = new Layer((int)$depth, (int)$range);
			};

			$this->count = array_key_last($this->layers);
		}

		public function output(): void
		{
			$values = [];

			for ($index = 0; $index <= $this->count; $index++)
			{
				$values[$index] = isset($this->layers[$index]) ? str_pad($this->layers[$index]->position, 2, " ", STR_PAD_LEFT) : "-";
			}

			echo(implode(" ", $values) . "\r");
		}

		public function step(): void
		{
			foreach ($this->layers as $layer)
			{
				$layer->step();
			}
		}

		public function run(): Result
		{
			$tick = 0;
			$severities = array();

			while (true)
			{
				$severities[$tick] = null;
				$from = max(0, $tick - $this->count);
				$index = min($this->count, $tick);

				for ($loop = $from; $loop <= $tick; $loop++)
				{
					if (isset($this->layers[$index]))
					{
						$layer = $this->layers[$index];

						if ($layer->position === 0)
						{
							$severities[$loop] += $layer->severity();
						}
					}

					$index--;
				}

				if ($tick > $this->count)
				{
					$completed = $tick - $this->count - 1;

					if ($severities[$completed] === null)
					{
						break;
					}
					elseif ($completed > 0)
					{
						unset($severities[$completed]);
					}
				}

				$tick++;

				$this->step();
			}

			return new Result($severities[0], ($tick - $this->count - 1));
		}
	}
?>
