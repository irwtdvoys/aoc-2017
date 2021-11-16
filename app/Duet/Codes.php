<?php
	namespace App\Duet;

	use Bolt\Enum;

	class Codes extends Enum
	{
		const ADD = "add";
		const JUMP = "jgz";
		const MODULO = "mod";
		const MULTIPLY = "mul";
		const RECEIVE = "rcv";
		const SEND = "snd";
		const SET = "set";
	}
?>
