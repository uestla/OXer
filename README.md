# OXer - Gomoku in PHP

## Installation

```shell
composer require uestla/oxer
```

## Usage

```php
use OXer\Board;
use OXer\Coord;
use OXer\Player;

$board = new Board;
$board->play(9, 9); // O
$board->play(8, 8); // X
// ...

$board->isGameOver(); // boolean
$board->getWinner(); // Player::O / Player::X / null
$board->getWinningLines(); // array of Coord[]
```
