<?php
// load config and db instance
require 'init.php';

$query = 'CREATE TABLE IF NOT EXISTS comment(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    guest VARCHAR(50) NOT NULL,
    message TEXT NOT NULL
) ENGINE=InnoDB
 CHARACTER SET=utf8;';

/**
 * @var \Guestbook\Db\Db $db
 */
if (isset($db)) {
    try {
        $db->migrate($query);
        print_r("Migration of 001_initial completed \n");
    } catch (\Guestbook\Db\DbException $e) {
        print_r($e->getMessage());
    }
} else {
    print_r("Database connection not initialized \n");
}
