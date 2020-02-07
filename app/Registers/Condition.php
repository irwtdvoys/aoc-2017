<?php
	namespace App\Registers;

	use Bolt\Base;

	class Condition extends Base
	{
		public string $register = "";
		public string $comparator = "";
		public int $value = 0;

		public function __toString()
		{
			return $this->register . " " . $this->comparator . " " . $this->value;
		}
	}
?>
