<?php

/**
 * This file is part of the OXer package
 *
 * @license  MIT
 * @author   Petr Kessler (https://kesspess.cz)
 * @link     https://github.com/uestla/OXer
 */

namespace OXer;


class Game
{

	/** @var int */
	private $width;

	/** @var int */
	private $height;

	/** @var int */
	private $winningLength;


	/** @var array */
	private $movesMap = [];

	/** @var array */
	private $movesList = [];


	/** @var bool */
	private $ended = FALSE;

	/** @var bool */
	private $winner = NULL;

	/** @var array */
	private $winningLine = NULL;


	const PLAYER_O = TRUE;
	const PLAYER_X = FALSE;


	/**
	 * @param  int $width
	 * @param  int $height
	 * @param  int $length
	 */
	public function __construct($width = 19, $height = 19, $length = 5)
	{
		$this->width = (int) $width;
		$this->height = (int) $height;
		$this->winningLength = (int) $length;

		$this->validateBoard();
	}


	/**
	 * @param  int $x
	 * @param  int $y
	 * @return void
	 */
	public function play($x, $y)
	{
		if ($this->ended) {
			throw new GameAlreadyEndedException;
		}

		$x = (int) $x;
		$y = (int) $y;

		if ($x < 0 || $y < 0 || $x >= $this->width || $y >= $this->height) {
			throw new InvalidMoveCoordinatesException;
		}

		if ($this->isFieldTaken($x, $y)) {
			throw new FieldAlreadyTakenException;
		}

		$this->addMove($x, $y);
		$this->detectEnd();
	}


	/** @return int */
	public function getWidth()
	{
		return $this->width;
	}


	/** @return int */
	public function getHeight()
	{
		return $this->height;
	}


	/** @return int */
	public function getWinningLength()
	{
		return $this->winningLength;
	}


	/** @return array */
	public function getMoves()
	{
		return $this->movesList;
	}


	/** @return array|NULL */
	public function getLastMove()
	{
		return end($this->movesList) ?: NULL;
	}


	/** @return array */
	public function getMovesMap()
	{
		return $this->movesMap;
	}


	/** @return bool */
	public function hasEnded()
	{
		return $this->ended;
	}


	/** @return bool */
	public function isDraw()
	{
		return $this->hasEnded() && !$this->hasWinner();
	}


	/** @return bool|NULL */
	public function getWinner()
	{
		return $this->winner;
	}


	/** @return bool */
	public function hasWinner()
	{
		return $this->getWinner() !== NULL;
	}


	/** @return array|NULL */
	public function getWinningLine()
	{
		return $this->winningLine;
	}


	/**
	 * @param  int $x
	 * @param  int $y
	 * @return bool|NULL
	 */
	public function getField($x, $y)
	{
		return isset($this->movesMap[$x][$y]) ? $this->movesMap[$x][$y] : NULL;
	}


	/**
	 * @param  int $x
	 * @param  int $y
	 * @return bool
	 */
	public function isFieldTaken($x, $y)
	{
		return $this->getField($x, $y) !== NULL;
	}


	/** @return bool|NULL */
	public function getPlayerOnTurn()
	{
		if ($this->ended) {
			return NULL;
		}

		return count($this->movesList) % 2 === 0 ? self::PLAYER_O : self::PLAYER_X;
	}


	/** @return bool|NULL */
	public function getLastPlayer()
	{
		$moveCount = count($this->movesList);

		if (!$moveCount) {
			return NULL;
		}

		return $moveCount % 2 === 0 ? self::PLAYER_X : self::PLAYER_O;
	}


	/** @return string */
	public function __toString()
	{
		return Serializer::serialize($this);
	}


	/** @return void */
	private function detectEnd()
	{
		do {
			$ended = FALSE;

			$last = end($this->movesList);
			if ($last === FALSE) {
				break;
			}

			$x = $last['x'];
			$y = $last['y'];
			$p = $this->getLastPlayer();

			foreach ([[0, 1], [1, 1], [1, 0], [1, -1]] as $dir) {
				$line = [[$x, $y]];

				foreach ([1, -1] as $subdir) {
					for ($i = 1; $i <= $this->winningLength; $i++) {
						$nx = $x + $subdir * $i * $dir[0];
						$ny = $y + $subdir * $i * $dir[1];

						if (isset($this->movesMap[$nx][$ny]) && $this->movesMap[$nx][$ny] === $p) {
							$line[] = [$nx, $ny];

						} else {
							break;
						}
					}
				}

				if (count($line) >= $this->winningLength) {
					$ended = TRUE;
					$this->winner = $p;
					$this->winningLine = $line;

					break 2;
				}
			}

			if (count($this->movesList) === $this->width * $this->height) {
				$ended = TRUE;
				break;
			}

		} while (FALSE);

		$this->ended = $ended;
	}


	/**
	 * @param  int $x
	 * @param  int $y
	 * @return void
	 */
	private function addMove($x, $y)
	{
		$this->movesList[] = [
			'x' => $x,
			'y' => $y,
		];

		$this->movesMap[$x][$y] = $this->getLastPlayer();
	}


	/** @return void */
	private function validateBoard()
	{
		if ($this->width < 3 || $this->height < 3) {
			throw new InvalidBoardDimensionsException('Board width and height must be 3 or bigger.');
		}

		if ($this->winningLength > $this->width || $this->winningLength > $this->height) {
			throw new InvalidWinningLengthArgumentException('Winning length must be equal or smaller than board width and height.');
		}
	}

}
