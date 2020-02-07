<?php
	namespace App\Tree;

	class Node
	{
		public string $name;
		public int $weight;
		/** @var Node[] */
		public array $children;

		public function __construct(object $data)
		{
			$this->name = $data->name;
			$this->weight = $data->weight;
			$this->children = $data->children;
		}

		public function isBalanced(): bool
		{
			if (count($this->children) === 0)
			{
				return true;
			}

			$weights = array();

			for ($index = 0; $index < count($this->children); $index++)
			{
				$weights[] = $this->children[$index]->weight();
			}

			return (count(array_count_values($weights)) === 1) ? true : false;

		}

		public function weight(): int
		{
			$weight = $this->weight;

			foreach ($this->children as $child)
			{
				$weight += $child->weight();
			}

			return $weight;
		}

		public function check(int $diff = 0)
		{
			$weights = array();

			for ($index = 0; $index < count($this->children); $index++)
			{
				$weights[] = $this->children[$index]->weight();
			}

			$counts = array_count_values($weights);
			asort($counts);
			$counts = array_values(array_flip($counts));

			$index = array_flip($weights)[$counts[0]];

			if ($this->isBalanced())
			{
				return $this->weight - $diff;
			}

			return $this->children[$index]->check($counts[0] - $counts[1]);
		}
	}
?>
