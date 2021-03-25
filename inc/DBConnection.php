<?php

class DBConnection {
    const SERVERNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "mysql";
    const DBNAME = "ToDoList";

    /**
     * creates a connection with database
     */
    private static function createPDOConnection() {
        $dbh = new PDO("mysql:host=". self::SERVERNAME .";dbname=". self::DBNAME, self::USERNAME, self::PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbh;

    }

    /**
     * run given sql code
     * 
     * @param string $sql SQL code to run
     * @param array $fields
     *  
     * @return mixed $stmt
     */
    public static function runSql($sql, array $fields = null){
        try {
            $dbh = DBConnection::createPDOConnection();
            if (is_null($fields)) {
                $stmt = $dbh->query($sql);
                return $stmt;
            } else {
                $stmt = $dbh->prepare($sql);
                $stmt->execute($fields);
                return $stmt;
            }
          }
          catch (PDOexception $e) {
              echo "Error is: " . $e->getmessage();
              die();
          }
    }
} 