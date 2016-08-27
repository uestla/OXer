OXer
====

OXer is a simple Tic Tac Toe implementation in PHP with no 3rd party dependency.


Installation
------------

```
composer require uestla/oxer
```


Usage
-----

```php
$game = new OXer\Game(19, 19, 5); // board 19×19, winning length 5

// coordinates are indexed from zero
$game->play(1, 3); // player O
$game->play(4, 5); // player X

// simple API:
$moves = $game->getMoves();
$ended = $game->hasEnded();
$draw = $game->isDraw();
$winner = $game->getWinner();
$line = $game->getWinningLine();

// board can be serialized
$s = OXer\Serializer::serialize($game);

// and unserialized
$game = OXer\Serializer::unserialize($s);
```

For more info see the tests.

Have fun! :-)
