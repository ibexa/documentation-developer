#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use EzSystems\Raml2Html\Application;

$app = new Application();
$app->run();

