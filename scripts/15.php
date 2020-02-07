<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	class Genny
	{
		private int $factor;
		public int $value;
		private int $multiple;

		public function __construct(int $factor, int $value, int $multiple = null)
		{
			$this->factor = $factor;
			$this->value = $value;
			$this->multiple = $multiple;
		}

		public function process()
		{
			while (true)
			{
				$this->value = ($this->value * $this->factor) % 2147483647;

				if ($this->multiple === null || $this->value % $this->multiple === 0)
				{
					break;
				}
			}
		}
	}

	class Judge
	{
		private Genny $a;
		private Genny $b;
		private int $part;

		public function __construct(int $part = 1)
		{
			$this->a = new Genny(16807, 116, ($part === 1 ? null : 4));
			$this->b = new Genny(48271, 299, ($part === 1 ? null : 8));

			$this->part = $part;
		}

		private function binary(int $value): string
		{
			return substr(base_convert($value, 10, 2), -16);
		}

		public function run()
		{
			$count = 0;
			$max = ($this->part === 1) ? 40000000 : 5000000;
			$judgement = 0;

			while ($count < $max)
			{
				echo($count . "\r");

				$this->a->process();
				$this->b->process();

				$count++;

				if ($this->binary($this->a->value) === $this->binary($this->b->value))
				{
					$judgement++;
				}

			}

			dump($judgement);
		}
	}


	$tmp = new Judge(2);
	$tmp->run();

	// Part 1: 569
	// Part 2: 298
?>
