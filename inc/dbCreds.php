<?php

class dbCreds {
    const SERVERNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "mysql";
    const DBNAME = "ToDoList";

    public static function getServername() {
        return self::SERVERNAME;

    }

    public static function getUsername() {
        return self::USERNAME;

    }

    public static function getPassword() {
        return self::PASSWORD;

    }

    public static function getDbname() {
        return self::DBNAME;

    }

} 