<?php

// config
require 'config/application.php';

// load libraries
require 'vendor/autoload.php';

if (isset($config['db'])) {
    try {
        $db = new \Guestbook\Db\MySQLPdoDb(
            $config['db']['host'],
            $config['db']['port'],
            $config['db']['user'],
            $config['db']['password'],
            $config['db']['dbname']
        );
        $db->init();
    } catch (\Guestbook\Db\DbException $dbe) {
        print_r($dbe->getMessage());
    } catch (\Exception $e) {
        print_r($e->getMessage());
    }
}
