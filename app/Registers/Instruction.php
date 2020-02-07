<?php
	namespace App\Registers;

	use App\Registers\Condition;
	use Bolt\Base;

	class Instruction extends Base
	{
		public string $register = "";
		public string $method = "";
		public int $value = 0;
		public Condition $condition;

		public function __construct($data = null)
		{
			$this->condition = new Condition();

			parent::__construct($data);
		}
	}
?>
