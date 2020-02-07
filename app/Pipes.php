<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Pipes\Program;

	class Pipes extends Helper
	{
		/** @var Program[] */
		private array $programs = array();
		private array $visited = array();

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$rows = explode(PHP_EOL, parent::load($override));

			$data = array();

			foreach ($rows as $row)
			{
				list($id, $links) = explode(" <-> ", $row);

				$links = array_map(
					function ($item)
					{
						return (int)$item;
					},
					explode(", ", $links)
				);

				$id = (int)$id;

				$data[$id] = $links;
				$this->programs[$id] = new Program($id);
			}

			foreach ($data as $id => $links)
			{
				foreach ($links as $link)
				{
					$this->programs[$id]->link($this->programs[$link]);
				}
			}
		}

		public function count(Program $node): int
		{
			$count = 1;
			$this->visited[] = $node->name;

			foreach ($node->connections as $connection)
			{
				if (!in_array($connection->name, $this->visited))
				{
					$count += $this->count($connection);
				}
			}

			return $count;
		}

		public function traverse(Program $node): void
		{
			$this->visited[] = $node->name;

			foreach ($node->connections as $connection)
			{
				if (!in_array($connection->name, $this->visited))
				{
					$this->traverse($connection);
				}
			}
		}

		public function groups(): int
		{
			$this->visited = array();

			$count = 0;

			foreach ($this->programs as $program)
			{
				if (!in_array($program->name, $this->visited))
				{
					$count++;
					$this->traverse($program);
				}
			}

			return $count;
		}

		public function run(): Result
		{
			return new Result($this->count($this->programs[0]), $this->groups());
		}
	}
?>
