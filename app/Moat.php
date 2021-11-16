<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Moat\Bridge;
	use App\Moat\Component;

	class Moat extends Helper
	{
		/** @var Component[] $components */
		private array $components = [];

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$rows = explode(PHP_EOL, parent::load($override));

			foreach ($rows as $row)
			{
				$this->components[] = new Component($row);
			}
		}

		public function process(Bridge $bridge, array $components, int $pins): array
		{
			$results = [$bridge];

			for ($index = 0; $index < count($components); $index++)
			{
				$component = $components[$index];

				if ($component->connectable($pins))
				{
					$tmp = clone $bridge;
					$tmp->add($component);

					$remaining = $components;
					array_splice($remaining, $index, 1);

					$results = array_merge($results, $this->process($tmp, $remaining, $component->other($pins)));
				}
			}

			return $results;
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$bridges = $this->process(new Bridge(), $this->components, 0);

			$result->part1 = max(
				array_map(
					function ($element)
					{
						return $element->strength();
					},
					$bridges
				)
			);

			$strengths = [];

			foreach ($bridges as $bridge)
			{
				$strengths[$bridge->length()][] = $bridge->strength();
			}

			$result->part2 = max($strengths[max(array_keys($strengths))]);

			return $result;
		}
	}
?>
