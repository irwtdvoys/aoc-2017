<?php
	namespace App\LinkedList;

	class Node
	{
		public int $data;
		public ?Node $previous = null;
		public ?Node $next = null;

		public function __construct($data, Node $previous = null, Node $next = null)
		{
			$this->data = $data;
			$this->previous = $previous;
			$this->next = $next;
		}

		public function flip()
		{
			$tmp = $this->next;
			$this->next = $this->previous;
			$this->previous = $tmp;
		}
	}
?>
