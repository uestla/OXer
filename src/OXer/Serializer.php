<?php

/**
 * This file is part of the OXer package
 *
 * @license  MIT
 * @author   Petr Kessler (https://kesspess.cz)
 * @link     https://github.com/uestla/OXer
 */

namespace OXer;


class Serializer
{

	const SEP_DIMS = '-';
	const SEP_MOVE = "\n";
	const SEP_COORD = ':';


	/**
	 * @param  Game $game
	 * @return string
	 */
	public static function serialize(Game $game)
	{
		$s = $game->getWidth() . self::SEP_DIMS
				. $game->getHeight() . self::SEP_DIMS
				. $game->getWinningLength();

		foreach ($game->getMoves() as $move) {
			$s .= self::SEP_MOVE . $move['x'] . self::SEP_COORD . $move['y'];
		}

		return $s;
	}


	/**
	 * @param  string $s
	 * @return Game
	 */
	public static function unserialize($s)
	{
		foreach (explode(self::SEP_MOVE, $s) as $move) {
			if (!isset($game)) {
				$dims = explode(self::SEP_DIMS, $move, 3);
				$game = new Game($dims[0], $dims[1], $dims[2]);

			} else {
				$coords = explode(self::SEP_COORD, $move, 2);
				$game->play($coords[0], $coords[1]);
			}
		}

		return $game;
	}

}
