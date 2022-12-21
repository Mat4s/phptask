<?php

class mysql
{
    protected static $connection;

    public static function connect()
    {
        if (!isset(self::$connection)) {
            self::$connection = new mysqli(config::DB_SERVER, config::DB_USERNAME, config::DB_PASSWORD, config::DB_NAME);

            if (self::$connection !== false) {
                if (!mysql::$connection->set_charset("utf8")) {
                    printf("Error loading character set: %s\n", self::$connection->error);
                }
            } else {
                return false;
            }
        }
        return self::$connection;
    }

    public static function query($query)
    {
        // Connect to the database
        $connection = mysql::connect();

        // Query the database
        $result = $connection->query($query);

        return $result;
    }

    public static function select($query)
    {
        $rows = array();
        $result = mysql::query($query);
        if ($result === false) {
            return false;
        }
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function error()
    {
        $connection = mysq::connect();
        return $connection->error;
    }

    public static function quote($value)
    {
        $connection = mysql::connect();
        return "'" . $connection->real_escape_string($value) . "'";
    }

    public static function getLastInsertedId()
    {
        $connection = mysql::connect();
        return $connection->insert_id;
    }

    public static function escape($field)
    {
        $connection = mysql::connect();
        return mysqli_real_escape_string($connection, $field);
    }

}