<?php

declare(strict_types = 1);

namespace OXer;

final class Board
{

	/** @var Coord[] */
	private array $moves = [];

	/** @var array<string, Player> */
	private array $moveMap = [];

	/** @var Coord[][] */
	private array $winningLines = [];

	private ?Player $winner = null;

	private const SIZE = 19;
	private const WINNING_LENGTH = 5;

	public function play(int $x, int $y): void
	{
		if ($this->isGameOver()) {
			throw OXerException::gameAlreadyEnded();
		}

		$coord = new Coord($x, $y);

		if ($this->isOutOfBounds($coord)) {
			throw OXerException::outOfBounds($coord, self::SIZE);
		}

		if (isset($this->moveMap[(string) $coord])) {
			throw OXerException::fieldAlreadyTaken($coord);
		}

		$player = $this->getPlayerOnTurn();

		$this->moves[] = $coord;
		$this->moveMap[(string) $coord] = $player;

		$this->detectEnd();
	}

	public function isGameOver(): bool
	{
		return $this->winner !== null;
	}

	public function getWinner(): ?Player
	{
		return $this->winner;
	}

	/** @return Coord[][] */
	public function getWinningLines(): array
	{
		return $this->winningLines;
	}

	private function getPlayerOnTurn(): Player
	{
		return count($this->moves) % 2 === 0 ? Player::O : Player::X;
	}

	private function isOutOfBounds(Coord $coord): bool
	{
		return $coord->x < 0 || $coord->x >= self::SIZE
			|| $coord->y < 0 || $coord->y >= self::SIZE;
	}

	private function detectEnd(): void
	{
		$lastMove = end($this->moves);

		if ($lastMove === false) {
			return ;
		}

		$lastPlayer = $this->getPlayerOnTurn()->opponent();

		$dirs = [
			[0, 1],
			[1, 1],
			[1, 0],
			[1, -1],
		];

		$winningLines = [];

		foreach ($dirs as $dir) {
			$line = [$lastMove];

			foreach ([1, -1] as $multiplier) {
				[$xDiff, $yDiff] = $dir;

				$xDiff *= $multiplier;
				$yDiff *= $multiplier;

				$checkCoord = $lastMove;

				while (true) {
					$checkCoord = $checkCoord->move($xDiff, $yDiff);

					if ($this->isOutOfBounds($checkCoord) || !$this->isPlayerField($checkCoord, $lastPlayer)) {
						break;
					}

					$line[] = $checkCoord;
				}
			}

			if (count($line) >= self::WINNING_LENGTH) {
				$winningLines[] = $line;
			}
		}

		if ($winningLines !== []) {
			$this->winningLines = $winningLines;
			$this->winner = $lastPlayer;
		}
	}

	private function isPlayerField(Coord $coord, Player $player): bool
	{
		return ($this->moveMap[(string) $coord] ?? null) === $player;
	}

}
