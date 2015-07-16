<?php
return array(
    'class'                 => 'CDbConnection',
    'connectionString'      => 'mysql:host=localhost;dbname=blagovest',
    'username'              => 'blago',
    'password'              => 'AYWHbbQp',
    'charset'               => 'utf8',
    'tablePrefix'           => 'aes_',
    'emulatePrepare'        => true,
    'enableProfiling'       => true,
    'enableParamLogging'    => true,
    'schemaCachingDuration' => 180,
    'driverMap'             => array(
        /*
          'pgsql' => 'CPgsqlSchema', //PostgreSQL
          'sqlite' => 'CSqliteSchema', //Sqlite 3
          'sqlite2' => 'CSqliteSchema', //Sqlite 2
          'mssql' => 'CMssqlSchema', //Mssql driver on windows hosts
          'dblib' => 'CMssqlSchema', //Dblib drivers on linux (and maybe others os) hosts
          'sqlsrv' => 'CMssqlSchema', //Mssql
          'oci' => 'COciSchema', //Oracle driver
         */
        'mysqli' => 'CMysqlSchema', //MySQL
        'mysql'  => 'CMysqlSchema', //MySQL
    ),
);
