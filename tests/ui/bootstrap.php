<?php

use BwsShop\Ui\Pages\PageFactory;

$loader = require __DIR__ . '/../../vendor/autoload.php';
$loader->addPsr4('BwsShop\\Ui\\', __DIR__ . '/');

PageFactory::setBaseUrl(getenv('BASE_URL'));
