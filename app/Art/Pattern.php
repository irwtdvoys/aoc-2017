<?php
	namespace App\Art;

	use Exception;

	class Pattern
	{
		const FLIP_HORIZONTAL = "horizontal";
		const FLIP_VERTICAL = "vertical";
		const ROTATE_LEFT = "left";
		const ROTATE_RIGHT = "right";
		const TILE_OFF = ".";
		const TILE_ON = "#";
		const TILE_SEPARATOR = "/";
		/** @var bool[][] */
		public array $art;

		public function __construct($data)
		{
			if (is_array($data))
			{
				$string = $this->array2String($data);
			}
			elseif (is_string($data))
			{
				$string = $data;
			}
			else
			{
				throw new Exception("Unknown data format");
			}

			$rows = explode(self::TILE_SEPARATOR, $string);

			$result = array();

			foreach ($rows as $row)
			{
				$elements = array_map(
					function ($element)
					{
						return ($element === self::TILE_ON) ? true : false;
					},
					str_split($row)
				);

				$result[] = $elements;
			}

			$this->art = $result;
		}

		public function flip($type): self
		{
			switch ($type)
			{
				case self::FLIP_HORIZONTAL:

					foreach ($this->art as &$next)
					{
						$next = array_reverse($next);
					}

					break;
				case self::FLIP_VERTICAL:

					$this->art = array_reverse($this->art);

					break;
			}

			return $this;
		}

		public function rotate(): self
		{
			$size = count($this->art);
			$result = array();

			for ($x = 0; $x < $size; $x++)
			{
				for ($y = 0; $y < $size; $y++)
				{
					$result[$size - $x - 1][$y] = $this->art[$size - $y - 1][$x];
				}
			}

			$this->art = array_values($result);

			return $this;
		}

		private function array2String(array $array): string
		{
			return implode(
				self::TILE_SEPARATOR,
				array_map(
					function ($row)
					{
						$elements = array_map(
							function ($element)
							{
								return ($element === true) ? self::TILE_ON : self::TILE_OFF;
							},
							$row
						);

						return implode("", $elements);
					},
					$array
				)
			);
		}

		public function encode(): string
		{
			return $this->array2String($this->art);
		}

		public function draw(): void
		{
			$encoded = $this->encode();

			echo(implode(PHP_EOL, explode(self::TILE_SEPARATOR, $encoded)) . PHP_EOL . PHP_EOL);
		}

		public function size(): int
		{
			return count($this->art);
		}

		public function split(int $value): array
		{
			$size = $this->size();

			$result = array();

			for ($x = 0; $x < $size; $x++)
			{
				for ($y = 0; $y < $size; $y++)
				{
					$qX = floor($x / $value);
					$qY = floor($y / $value);

					$result[$qX][$qY][$x - ($value * $qX)][$y - ($value * $qY)] = $this->art[$x][$y];
				}
			}

			foreach ($result as &$row)
			{
				foreach ($row as &$element)
				{
					$element = new Pattern($element);
				}
			}

			return $result;
		}
	}
?>
