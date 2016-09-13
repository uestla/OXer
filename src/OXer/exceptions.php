<?php

/**
 * This file is part of the OXer component
 *
 * Copyright (c) 2016 Petr Kessler (http://kesspess.1991.cz)
 *
 * @license  MIT
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
