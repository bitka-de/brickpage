<?php

declare(strict_types=1);

const ROOT_DIR = __DIR__ . '/..';

const VENDOR_DIR = ROOT_DIR . '/vendor';
const APP_DIR = ROOT_DIR . '/app';
const CONFIG_DIR = APP_DIR . '/config';
const VIEW_DIR = APP_DIR . '/views';

require VENDOR_DIR . '/autoload.php';

(new Brick\Core\App())->run();
