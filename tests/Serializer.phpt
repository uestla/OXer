<?php

use OXer\Game;
use Tester\Assert;
use OXer\Serializer;

require_once __DIR__ . '/bootstrap.php';


test(function () {
	$game = new Game;
	Assert::same('19-19-5', Serializer::serialize($game));

	$game->play(0, 0);
	$game->play(1, 4);
	$game->play(3, 8);
	$game->play(11, 15);
	$game->play(8, 2);

	$s = Serializer::serialize($game);

	Assert::same("19-19-5\n0:0\n1:4\n3:8\n11:15\n8:2", $s);
	Assert::same("19-19-5\n0:0\n1:4\n3:8\n11:15\n8:2", (string) $game);

	Assert::equal(Serializer::unserialize($s), $game);
});
