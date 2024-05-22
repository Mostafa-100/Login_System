<?php

class Db
{
    private static $instance = null;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO("mysql:host=localhost; dbname=login_system", "root");
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return self::$instance;
            } catch (PDOException $e) {
                echo "Error in conneceting to database" . $e->getMessage();
            }
        }

        return self::$instance;
    }
}
