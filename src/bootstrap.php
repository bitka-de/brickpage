<?php

declare(strict_types=1);

const ROOT_DIR = __DIR__ . '/..';

const SRC_DIR = ROOT_DIR . '/src';
const VENDOR_DIR = ROOT_DIR . '/vendor';
const APP_DIR = ROOT_DIR . '/app';
const CONFIG_DIR = APP_DIR . '/config';
const VIEW_DIR = APP_DIR . '/views';

require VENDOR_DIR . '/autoload.php';

// Globale Helper-Funktionen laden
require SRC_DIR . '/helpers.php';

// Development-Modus aus Konfiguration laden
$isDev = Brick\Core\Config::get('dev_mode', false);
Brick\Core\AssetHelper::setDev($isDev);

// Globale Konfiguration initialisieren
_init_config();

(new Brick\Core\App())->run();
