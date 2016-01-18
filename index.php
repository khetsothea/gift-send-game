<?php
date_default_timezone_set('Europe/Lisbon'); 

require __DIR__.'/inc/game.php';

$game = new Game();

$game->start();