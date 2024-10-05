<?php

declare(strict_types = 1);

namespace OXer;

enum Player
{

	case O;
	case X;

	public function opponent(): self
	{
		return $this === self::O ? self::X : self::O;
	}
}
