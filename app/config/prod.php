<?php
/**
 * User: Naeva
 * Date: 16/12/2017
 */

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8',
    'host'     => 'localhost',
    'port'     => '3307',
    'dbname'   => 'mescontacts',
    'user'     => 'mescontacts_user',
    'password' => 'secret',
);
