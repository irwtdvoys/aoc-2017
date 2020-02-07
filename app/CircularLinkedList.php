<?php
	namespace App;

	use App\LinkedList\Node;

	class CircularLinkedList extends LinkedList
	{
		public function next(): void
		{
			$this->current = $this->current->next;
			$this->index = ($this->index + 1) % $this->count;
		}

		public function previous(): void
		{
			$this->current = $this->current->previous;
			$this->index = ($this->index === 0) ? $this->count - 1 : $this->index - 1;
		}

		public function push($data): void
		{
			if (!isset($this->first))
			{
				$new = new Node($data);

				$this->first = $new;
				$this->first->previous = $new;
				$this->first->next = $new;

				$this->current = $new;
			}
			else
			{
				$new = new Node($data, $this->first->next, $this->first);

				$this->first->previous->next = $new;
				$this->first->previous = $new;
			}

			$this->count++;
			$this->index++;
		}

		public function get(int $index): int
		{
			$pointer = $this->first;

			for ($loop = 0; $loop < $index; $loop++)
			{
				$pointer = $pointer->next;
			}

			return $pointer->data;
		}
	}
?>
