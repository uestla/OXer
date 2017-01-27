<?php

/**
 * This file is part of the OXer package
 *
 * @license  MIT
 * @author   Petr Kessler (https://kesspess.cz)
 * @link     https://github.com/uestla/OXer
 */

namespace OXer;


class InvalidBoardDimensionsException extends \Exception
{}


class InvalidWinningLengthArgumentException extends \Exception
{}


class GameAlreadyEndedException extends \Exception
{}


class InvalidMoveCoordinatesException extends \Exception
{}


class FieldAlreadyTakenException extends \Exception
{}
