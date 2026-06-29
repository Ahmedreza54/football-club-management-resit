<?php
declare(strict_types=1);

return [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'name' => getenv('DB_NAME') ?: 'football',
    'user' => getenv('DB_USER') ?: 'root',
    'pass' => getenv('DB_PASS') ?: '',

    // Football API
    'football_api_key' => '50db489ba28d4125a0320be0e2fe8169',
];