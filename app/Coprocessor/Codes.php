<?php
	namespace App\Coprocessor;

	use Bolt\Enum;

	class Codes extends Enum
	{
		const SET = "set";
		const SUB = "sub";
		const MULTIPLY = "mul";
		const JUMP = "jnz";
	}
?>
