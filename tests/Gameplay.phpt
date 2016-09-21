<?php

use OXer\Game;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';


test(function () {
	$game = new Game(3, 3, 3);

	for ($x = 1; $x <= $game->getWidth(); $x++) {
		for ($y = 1; $y <= $game->getHeight(); $y++) {
			Assert::false($game->isFieldTaken($x, $y));
			Assert::same(NULL, $game->getField($x, $y));
		}
	}

	$game->play(0, 0);

	Assert::same([
		'x' => 0,
		'y' => 0,

	], $game->getLastMove());

	Assert::same([
		['x' => 0, 'y' => 0]

	], $game->getMoves());

	Assert::same([
		0 => [
			0 => Game::PLAYER_O,
		]

	], $game->getMovesMap());


	$game->play(1, 0);

	Assert::same([
		'x' => 1,
		'y' => 0,

	], $game->getLastMove());

	Assert::same([
		['x' => 0, 'y' => 0],
		['x' => 1, 'y' => 0]

	], $game->getMoves());

	Assert::same([
		0 => [
			0 => Game::PLAYER_O,
		],
		1 => [
			0 => Game::PLAYER_X,
		],

	], $game->getMovesMap());

	Assert::true($game->isFieldTaken(0, 0));
	Assert::true($game->isFieldTaken(1, 0));
	Assert::same(Game::PLAYER_O, $game->getField(0, 0));
	Assert::same(Game::PLAYER_X, $game->getField(1, 0));

	$game->play(0, 1);
	$game->play(1, 1);

	$game->play(0, 2);

	testGameEnd($game, 1, 2, Game::PLAYER_O, [[0, 2], [0, 1], [0, 0]]);
});


test(function () {
	$game = new Game;

	$game->play(0, 0);
	$game->play(1, 1);

	$game->play(1, 0);
	$game->play(2, 2);

	$game->play(2, 0);
	$game->play(3, 3);

	$game->play(3, 0);
	$game->play(4, 4);

	$game->play(5, 0);
	$game->play(6, 6);

	$game->play(6, 0);
	$game->play(7, 7);

	$game->play(7, 0);
	$game->play(8, 8);

	$game->play(8, 0);
	$game->play(9, 9);

	$game->play(4, 0);

	testGameEnd($game, 10, 10, Game::PLAYER_O, [[4, 0], [5, 0], [6, 0], [7, 0], [8, 0], [3, 0], [2, 0], [1, 0], [0, 0]]);
});


function testGameEnd(Game $game, $x, $y, $winner, array $line)
{
	Assert::exception(function () use ($game, $x, $y) {
		$game->play($x, $y);

	}, OXer\GameAlreadyEndedException::class);

	Assert::true($game->hasEnded());
	Assert::false($game->isDraw());

	Assert::same($winner, $game->getWinner());
	Assert::same($line, $game->getWinningLine());
}
