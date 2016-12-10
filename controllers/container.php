<?php
    //Add Monolog
    $container['logger'] = function($c) {
        $logger = new \Monolog\Logger('my_logger');
        $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
        $logger->pushHandler($file_handler);
        return $logger;
        //$this->logger->addInfo("Something interesting happened");
    };

    //Add Database Connection
    $container['db'] = function ($c) {
        $db = $c['settings']['db'];
        $dsn = 'mysql:host=' .$db['host']. ';port=' .$db['port']. ';dbname=' .$db['dbname'];
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'],
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            $pdo = null;
        }
        return $pdo;
    };