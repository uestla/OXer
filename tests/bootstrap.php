<?php

require_once __DIR__ . '/../src/oxer.php';
require_once __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


function test(\Closure $f) {
	$f();
}
