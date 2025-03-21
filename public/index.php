<?php

use Config\Env;

require __DIR__ . '/../vendor/autoload.php';

Env::load(__DIR__ . '/../.env');

require_once __DIR__ . '/../src/Routes/route.php';


