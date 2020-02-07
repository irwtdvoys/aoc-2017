<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Tree\Node;

	class Tree extends Helper
	{
		private array $programs;
		private Node $tree;

		public function __construct(int $day, string $override = null)
		{
			parent::__construct($day);

			$this->loadData($override);
			$this->generateTree();
		}

		public function loadData(string $override = null)
		{
			$data = parent::load($override);

			$pattern = "/(?'name'[a-z]+) \((?'weight'[0-9]+)\)( -> )?(?'children'[a-z ,]+)?/";

			preg_match_all($pattern, $data, $matches);

			$programs = array();

			for ($index = 0; $index < count($matches[0]); $index++)
			{
				$programs[] = (object)array(
					"name" => $matches['name'][$index],
					"weight" => (int)$matches['weight'][$index],
					"children" => array_filter(explode(", ", $matches['children'][$index]))
				);
			}

			$this->programs = $programs;
		}

		public function generateTree()
		{
			$children = array();
			$programs = array();

			foreach ($this->programs as $program)
			{
				$names[] = $program->name;
				$programs[$program->name] = $program;

				if (count($program->children) > 0)
				{
					$children = array_merge($children, $program->children);
				}
			}

			$root = array_values(array_diff(array_keys($programs), $children))[0];

			$this->tree = $this->inflate(clone $programs[$root], $programs);
		}

		private function inflate($node, $programs)
		{
			if (count($node->children) > 0)
			{
				foreach ($node->children as &$child)
				{
					$child = $this->inflate($programs[$child], $programs);
				}
			}

			return new Node($node);
		}

		public function run(): Result
		{
			return new Result($this->tree->name, $this->tree->check());
		}
	}
?>
