<?php

declare(strict_types = 1);

namespace OXer;


final class OXerException extends \Exception
{

	public static function gameAlreadyEnded(): self
	{
		return new self('Game already ended.');
	}

	public static function outOfBounds(Coord $coord, int $size): self
	{
		return new self(sprintf('Invalid coordination %s for board of size %d.', $coord, $size));
	}

	public static function fieldAlreadyTaken(Coord $coord): self
	{
		return new self(sprintf('Field %s is already taken.', $coord));
	}

}
