<?php

class ListModel
{

    // private $servername = dbCreds::getServername();
    // private $username = dbCreds::getUsername();
    // private $password = dbCreds::getPassword();
    // private $dbname = dbCreds::getDbname();

    /**
     * get all lists
     *
     */
    public static function getLists(){
        $servername = dbCreds::getServername();
        $username = dbCreds::getUsername();
        $password = dbCreds::getPassword();
        $dbname = dbCreds::getDbname();
        try {
            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $sql = "SELECT * FROM Lists";
            $lists = $dbh->query($sql);
            $dbh = null;
            return $lists;
          }
          catch (PDOexception $e) {
              echo "Error is: " . $e->getmessage();
              die();
          }
    }

    public static function newList($name){
        $servername = dbCreds::getServername();
        $username = dbCreds::getUsername();
        $password = dbCreds::getPassword();
        $dbname = dbCreds::getDbname();
        try {
            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO Lists (listName)
            VALUES (:listname)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([":listname"=>$name]);
          }
          catch (PDOexception $e) {
              echo "Error is: " . $e->getmessage();
              die();
          }
    }

    public static function editList($name, $id){
        $servername = dbCreds::getServername();
        $username = dbCreds::getUsername();
        $password = dbCreds::getPassword();
        $dbname = dbCreds::getDbname();
        try {
            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `Lists` SET `listName`=:listname WHERE `id`= :id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([":listname"=>$name,
                            ":id"=>$id]);
          }
          catch (PDOexception $e) {
              echo "Error is: " . $e->getmessage();
              die();
          }
    }

    public static function deleteList($id){
        $servername = dbCreds::getServername();
        $username = dbCreds::getUsername();
        $password = dbCreds::getPassword();
        $dbname = dbCreds::getDbname();
        try {
            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM `Lists` WHERE `id`=:id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([":id"=>$id]);
          }
          catch (PDOexception $e) {
              echo "Error is: " . $e->getmessage();
              die();
          }
    }

    public function sayHi(){
      echo 'hi';
    }
}
