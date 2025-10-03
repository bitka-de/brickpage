<?php

declare(strict_types=1);

return [
    'env' => 'development', # 'production' or 'development'
    'debug' => false, # true or false
    'dev_mode' => true, # true or false

    'app' => [
        'name' => 'Brickpage',
        'version' => '1.0.0',
        'url' => 'http://brickpage.test',
    ],
    
    // Legacy-Support (wird später entfernt)
    'app_name' => 'Brickpage',
    'app_version' => '1.0.0',
    'url' => 'http://brickpage.test',
    

    'log' => [
        'level' => 'debug', // 'debug', 'info', 'warning', 'error'
    ],
    
    // Legacy-Support
    'log_level' => 'debug', # 'debug', 'info', 'warning', 'error'

    //Vite Configuration

    'vite' => [
        'dev_server' => 'http://localhost:3000',
        'build_directory' => 'src',
        'entry_point' => 'app/assets/js/app.js',
    ],
];