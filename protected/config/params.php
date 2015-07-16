<?php

if (isset($_SERVER['HOME']) && $_SERVER['HOME'] == '/var/www/egar/data') {
    return array(
        'HOST' => 'localhost',
        'DBNAME' => 'spam',
        'USER' => 'egar',
        'PASS' => '9slIkp1W',
        'from_email' => 'info@informbusiness.click',
        'from_name' => 'Информационный бизнес',
    );
} else {
    return array(
        'HOST' => 'localhost',
        'DBNAME' => 'balgovest',
        'USER' => 'root',
        'PASS' => '',
        'from_email' => 'info@informbusiness.click',
        'from_name' => 'Информационный бизнес',
    );
}

