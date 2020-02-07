<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\CircularLinkedList as LinkedList;

	class Hash extends Helper
	{
		public LinkedList $list;
		public int $size;
		public array $data;
		public array $ascii;

		public function __construct(int $day, string $override = null, $autoload = true)
		{
			parent::__construct($day);

			if ($autoload === true)
			{
				$this->loadData($override);
			}
		}

		public function loadData(string $override = null): void
		{
			$raw = parent::load($override);

			$this->data = array_map(
				function ($element)
				{
					return (int)$element;
				},
				explode(",", $raw)
			);

			$this->ascii = $this->parseAscii($raw);
		}

		private function parseAscii(string $string): array
		{
			return array_merge(
				array_map(
					function($element)
					{
						return ord($element);
					},
					str_split($string)
				),
				array(17, 31, 73, 47, 23)
			);
		}

		public function initialise(): void
		{
			$this->list = new LinkedList(256);
			$this->size = 0;
		}

		public function hash(int $length): void
		{
			$this->twist($length);
			$this->list->forward($length + $this->size);
			$this->size++;
		}

		public function process(array $lengths): void
		{
			foreach ($lengths as $next)
			{
				$this->hash($next);
			}
		}

		public function generateHash(string $data): string
		{
			$parsed = $this->parseAscii($data);
			$this->initialise();

			$count = 0;

			while ($count < 64)
			{
				$this->process($parsed);

				$count++;
			}

			$denseHash = $this->denseHash();

			return $this->toHex($denseHash);
		}

		public function run(): Result
		{
			$result = new Result();

			// Part 1
			$this->initialise();
			$this->process($this->data);

			$result->part1 = $this->list->get(0) * $this->list->get(1);

			// Part 2
			$result->part2 = $this->generateHash(parent::load());

			return $result;
		}

		public function denseHash(): array
		{
			$sparse = $this->list->data();

			$parts = array_chunk($sparse, 16);

			$results = array();

			foreach ($parts as $part)
			{

				$results[] = $this->reduce($part);
			}

			return $results;
		}

		public function reduce(array $data): int
		{
			$result = 0;

			foreach ($data as $value)
			{
				$result ^= $value;
			}

			return $result;
		}

		public function dec2Hex(int $value, int $length = 2): string
		{
			return str_pad(dechex($value), $length, "0", STR_PAD_LEFT);
		}

		public function toHex(array $denseHash): string
		{
			$result = "";

			foreach ($denseHash as $next)
			{
				$result .= $this->dec2Hex($next);
			}

			return $result;
		}

		public function twist($length): void
		{
			$values = array();

			$pointer = $this->list->current;

			for ($loop = 0; $loop < $length; $loop++)
			{
				$values[] = $pointer->data;
				$pointer = $pointer->next;
			}

			$values = array_reverse($values);

			$pointer = $this->list->current;

			for ($loop = 0; $loop < $length; $loop++)
			{
				$pointer->data = $values[$loop];
				$pointer = $pointer->next;
			}
		}
	}
?>
