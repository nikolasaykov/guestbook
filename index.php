<?php

// config
require 'config/application.php';

// load libraries
require 'vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($config['db'])) {
    try {
        // @TODO move this into a factory
        $db = new \Guestbook\Db\MySQLPdoDb(
            $config['db']['host'],
            $config['db']['port'],
            $config['db']['user'],
            $config['db']['password'],
            $config['db']['dbname']
        );
        $db->init();

        $commentRepository = new \Guestbook\Model\Comment\CommentRepository($db);
        $controller = new \Guestbook\Controller\CommentController($commentRepository);

        if (isset($_SERVER["REQUEST_METHOD"])  &&
            $_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['guest'])) {
                $controller->addParam('guest', $_POST['guest']);
            }
            if (isset($_POST['message'])) {
                $controller->addParam('message', $_POST['message']);
            }
            $controller->add();
        }
        if (isset($_GET['page'])) {
            $controller->addParam('page', $_GET['page']);
        }
        $controller->index();
    } catch (\Guestbook\Db\DbException $dbe) {
        print_r($dbe->getMessage());
    } catch (\Exception $e) {
        print_r($e->getMessage());
    }
}
