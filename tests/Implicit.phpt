<?php

use OXer\Game;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';


test(function () {
	$game = new Game;
	Assert::same($game->getWinningLength(), 5);
	Assert::same($game->getWidth(), 19);
	Assert::same($game->getHeight(), 19);
});


test(function () {
	Assert::exception(function () {
		new Game(0);

	}, Oxer\InvalidBoardDimensionsException::class);
});


test(function () {
	Assert::exception(function () {
		new Game(1, 0);

	}, Oxer\InvalidBoardDimensionsException::class);
});


test(function () {
	Assert::exception(function () {
		new Game(3, 3, 4);

	}, OXer\InvalidWinningLengthArgumentException::class);
});


test(function () {
	Assert::exception(function () {
		$game = new Game;
		$game->play(-1, 2);

	}, OXer\InvalidMoveCoordinatesException::class);
});


test(function () {
	$game = new Game;
	$game->play(0, 0);

	Assert::exception(function () use ($game) {
		$game->play(0, 0);

	}, OXer\FieldAlreadyTakenException::class);
});
