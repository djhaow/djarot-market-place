<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=your_database_name',
    // 'dsn' => 'mysql:host=localhost;port:8889;dbname=your_database_name;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock', //~~ MAMP user
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
