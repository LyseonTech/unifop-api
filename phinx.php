<?php
if(file_exists(__DIR__.'/.env')) {
    $dotenv = Dotenv\Dotenv::createMutable(__DIR__);
    $dotenv->load();
}

return [
    'paths' => [
        'migrations' => getenv('PHINX_CONFIG_DIR').'/db/migrations',
        'seeds' => getenv('PHINX_CONFIG_DIR').'/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',
        'production' => [
            'adapter' => getenv('DB_ADAPTER'),
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_NAME'),
            'user' => getenv('DB_USER'),
            'pass' => getenv('DB_PASSWD'),
            'port' => getenv('DB_PORT'),
            'charset' => 'utf8'
        ],
        'development' => [
            'adapter' => getenv('DB_ADAPTER'),
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_NAME'),
            'user' => getenv('DB_USER'),
            'pass' => getenv('DB_PASSWD'),
            'port' => getenv('DB_PORT'),
            'charset' => 'utf8'
        ]
    ],
    'version_order' => 'creation'
];