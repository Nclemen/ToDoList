<?php

class TaskModel
{
    public $taskName;
    public $taskDescription;
    public $taskListId;
    public $taskDuration;
    public $taskStatus;

    /**
     * creates a new task
     * 
     * @var string $sql the sql to be run
     * @var array $fields an array containing prepared statements for the sql
     * 
     * @param string $name task name
     * @param string $description task description
     * @param int $list_id the id of the list the task belongs to
     * @param int $minutes task minutes
     */
    public function newTask($name, $description, $list_id, $minutes){
        $sql = "INSERT INTO `Tasks`( `task_name`, `task_description`, `list_id`, `duration`) VALUES ( :taskname, :taskdescription, :listid, :minutes)";
        $fields =[  ":taskname"=>$name,
                    ":taskdescription"=>$description,
                    ":listid"=>$list_id,
                    ":minutes"=>"00:" . $minutes . ":00"];
        DBConnection::runSql($sql,$fields);
    }

    /**
     * edits specified task
     * 
     * @var string $sql the sql to be run
     * @var array $fields an array containing prepared statements for the sql
     * 
     * @param string $name task name
     * @param string $description task description
     * @param int $minutes task minutes
     * @param int $id task id
     * @param int $status task completion status
     */
    public function editTask($name, $description, $minutes, $id, $status){
        $sql = "UPDATE `Tasks` SET `task_name`=:taskname,`task_description`=:description, `duration`=:duration, `status`=:status WHERE `id`= :id";
        $fields = [":taskname"=>$name,
                    ":id"=>$id,
                    ":description"=>$description,
                    ":duration"=>"00:" . $minutes . ":00",
                    ":status"=>$status];
        DBConnection::runSql($sql,$fields);
    }

    /**
     * gets all tasks related to a list
     * 
     * @var string $sql the sql to be run
     * @var array $fields an array containing prepared statements for the sql
     * 
     * @param array $values values posted
     * @param int $list_id list id
     */
    public static function GetAllListTasks($list_id, array $values = null) {

        if (!is_null($values)) {
            $sql = 'SELECT * FROM `Tasks` WHERE `list_id` = :id AND `status`=:status ORDER BY `duration` ' . $values['duration'];
            $fields = [ ":status"=>$values['status'],
                        ":id"=>$list_id];
            $tasks = DBConnection::runSql($sql,$fields);
        } else {
            $sql = "SELECT * FROM Tasks WHERE list_id = " . $list_id;
            $tasks = DBConnection::runSql($sql);
      }
      
      return $tasks;
    }

    /**
     * deletes specified task
     * 
     * @var string $sql the sql to be run
     * @var array $fields an array containing prepared statements for the sql
     * 
     * @param int $id task id
     */
    public function deleteTask($id){
            $sql = "DELETE FROM `Tasks` WHERE `id`=:id";
            $fields = [":id"=>$id];
            $tasks = DBConnection::runSql($sql,$fields);
    }
    

}
