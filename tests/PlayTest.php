<?php

declare(strict_types = 1);

namespace OXer\Tests;

use OXer\Board;
use OXer\Coord;
use OXer\Player;
use Tester\Assert;
use Tester\Environment;
use OXer\OXerException;


require_once __DIR__ . '/../vendor/autoload.php';

Environment::setup();


(static function (): void {

	$board = new Board;
	Assert::false($board->isGameOver());
	Assert::null($board->getWinner());

	$movesO = [
		[ 5,  5], [ 6,  6], [ 7,  7], [ 8,  8],
		[ 9,  5], [ 9,  6], [ 9,  7], [ 9,  8],
		[13,  5], [12,  6], [11,  7], [10,  8],
		[ 5,  9], [ 6,  9], [ 7,  9], [ 8,  9],
		[10,  9], [11,  9], [12,  9], [13,  9],
		[ 8, 10], [ 7, 11], [ 6, 12], [ 5, 13],
		[ 9, 10], [ 9, 11], [ 9, 12], [ 9, 13],
		[10, 10], [11, 11], [12, 12], [13, 13],
		[ 9,  9],
	];

	$movesX = [
		[ 0,  0], [ 1,  0], [ 2,  0], [ 3,  0],
		[ 9,  0], [10,  0], [11,  0], [12,  0],
		[18,  0], [18,  1], [18,  2], [18,  3],
		[ 0,  6], [ 0,  7], [ 0,  8], [ 0,  9],
		[18,  9], [18, 10], [18, 11], [18, 12],
		[ 0, 15], [ 0, 16], [ 0, 17], [ 0, 18],
		[ 6, 18], [ 7, 18], [ 8, 18], [ 9, 18],
		[15, 18], [16, 18], [17, 18], [18, 18],
	];

	foreach ($movesO as $key => $move) {
		$board->play($move[0], $move[1]);

		if (isset($movesX[$key])) {
			$board->play($movesX[$key][0], $movesX[$key][1]);
			Assert::false($board->isGameOver());
			Assert::null($board->getWinner());
		}
	}

	Assert::true($board->isGameOver());
	Assert::same(Player::O, $board->getWinner());

	Assert::exception(static function () use ($board): void {
		$board->play(0, 0);
	}, OXerException::class, 'Game already ended.');

	Assert::equal([
		[new Coord(9, 9), new Coord( 9, 10), new Coord( 9, 11), new Coord( 9, 12), new Coord( 9, 13), new Coord(9,  8), new Coord(9,  7), new Coord(9,  6), new Coord(9,  5)],
		[new Coord(9, 9), new Coord(10, 10), new Coord(11, 11), new Coord(12, 12), new Coord(13, 13), new Coord(8,  8), new Coord(7,  7), new Coord(6,  6), new Coord(5,  5)],
		[new Coord(9, 9), new Coord(10,  9), new Coord(11,  9), new Coord(12,  9), new Coord(13,  9), new Coord(8,  9), new Coord(7,  9), new Coord(6,  9), new Coord(5,  9)],
		[new Coord(9, 9), new Coord(10,  8), new Coord(11,  7), new Coord(12,  6), new Coord(13,  5), new Coord(8, 10), new Coord(7, 11), new Coord(6, 12), new Coord(5, 13)],

	], $board->getWinningLines());

})();


(static function (): void {

	$board = new Board;

	Assert::exception(static function () use ($board): void {
		$board->play(-1, 0);
	}, OXerException::class, 'Invalid coordination [-1:0] for board of size 19.');

	Assert::exception(static function () use ($board): void {
		$board->play(0, -1);
	}, OXerException::class, 'Invalid coordination [0:-1] for board of size 19.');

	Assert::exception(static function () use ($board): void {
		$board->play(-1, -1);
	}, OXerException::class, 'Invalid coordination [-1:-1] for board of size 19.');

	Assert::exception(static function () use ($board): void {
		$board->play(19, 0);
	}, OXerException::class, 'Invalid coordination [19:0] for board of size 19.');

	Assert::exception(static function () use ($board): void {
		$board->play(0, 19);
	}, OXerException::class, 'Invalid coordination [0:19] for board of size 19.');

	Assert::exception(static function () use ($board): void {
		$board->play(19, 19);
	}, OXerException::class, 'Invalid coordination [19:19] for board of size 19.');

	$board->play(0, 0);

	Assert::exception(static function () use ($board): void {
		$board->play(0, 0);
	}, OXerException::class, 'Field [0:0] is already taken.');

})();
