<?php
	namespace App\Registers;

	use Bolt\Enum;

	class Comparators extends Enum
	{
		const EQUAL_TO = "==";
		const LESS_THAN = "<";
		const GREATER_THAN = ">";
		const NOT_EQUAL_TO = "!=";
		const LESS_THAN_OR_EQUAL_TO = "<=";
		const GREATER_THAN_OR_EQUAL_TO = ">=";
	}
?>
