<?php

declare(strict_types = 1);

namespace OXer;


final class Coord
{

	public function __construct(
		public readonly int $x,
		public readonly int $y,
	)
	{}

	public function move(int $xDiff, int $yDiff): Coord
	{
		return new self(
			$this->x + $xDiff,
			$this->y + $yDiff,
		);
	}

	public function __toString(): string
	{
		return sprintf('[%d:%d]', $this->x, $this->y);
	}

}
