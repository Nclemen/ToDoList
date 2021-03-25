<?php

class ListModel
{

    /**
     * gets all lists
     *
     * @var string $sql the sql to be run
     * 
     * @return lists
     */
    public static function getLists(){
        $sql = "SELECT * FROM Lists";

        return DBConnection::runSql($sql);
    }

    /**
     * creates a new list
     * 
     * @var string $sql the sql to be run
     * @var array $fields an array containing prepared statements for the sql
     * 
     * @param string $name the name of the new list
     */
    public function newList($name){
        $sql = "INSERT INTO Lists (listName) VALUES (:listname)";
        $fields = [":listname"=>$name];

        DBConnection::runSql($sql,$fields);
    }

    /**
     * edits specified list
     * 
     * @var string $sql the sql to be run
     * @var array $fields an array containing prepared statements for the sql
     * 
     * @param string $name
     * @param int $id
     */
    public function editList($name, $id){
        $sql = "UPDATE `Lists` SET `listName`=:listname WHERE `id`= :id";
        $fields =[
                ":listname"=>$name,
                ":id"=>$id
        ];
        DBConnection::runSql($sql,$fields);
    }

    /**
     * delete specified list
     * 
     * @var string $sql the sql to be run
     * @var array $fields an array containing prepared statements for the sql
     * 
     * @param int $id the id of the list to be deleted
     */
    public function deleteList($id){
        $sql = "DELETE FROM `Lists` WHERE `id`=:id";
        $fields = [":id"=>$id];

        DBConnection::runSql($sql,$fields);
    }
}
