<?php

use App\controllers\AnimalController;
use App\controllers\HomeController;

$app
    ->get('/', HomeController::class.":ActionIndex")
    ->setName("home");

$app
    ->get('/animals', AnimalController::class.":ActionIndex")
    ->setName("animals_index");

