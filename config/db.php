<?php

$dsn = env('DB_CONNECTION', 'mysql') . ':';
$dsn .= 'host=' . env('DB_HOST', '127.0.0.1') . ';';
$dsn .= 'port=' . env('DB_PORT', '3306') . ';';
$dsn .= 'dbname=' . env('DB_DATABASE', 'yii2basic');

return [
    'class' => 'yii\db\Connection',
    'dsn' => $dsn,
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', 'root'),
    'charset' => env('DB_CHARSET', 'utf8'),

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
