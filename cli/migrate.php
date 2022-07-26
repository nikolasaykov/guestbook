<?php

// config
require '../config/application.php';

// load libraries
require '../vendor/autoload.php';

$queries = array();

if (isset($config['Db'])) {
    try {
        $db = new \Guestbook\Db\MySQLPdoDb(
            $config['Db']['host'],
            $config['Db']['port'],
            $config['Db']['user'],
            $config['Db']['password'],
            $config['Db']['dbname']
        );
        $db->init();
        // @TODO dynamically load all migration files
        include '../migrations/0001_initial.php';

        foreach ($queries as $query) {
            $db->migrate($query);
        }
        print_r("Migration completed \n");
    } catch (\Guestbook\Db\DbException $dbe) {
        print_r($dbe->getMessage());
    } catch (\Exception $e) {
        print_r($e->getMessage());
    }
}