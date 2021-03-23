<?php

class TaskModel
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    public $taskName;
    public $taskDescription;
    public $taskListId;
    public $taskDuration;
    public $taskStatus;

    function __construct()
    {
     $this->servername = dbCreds::getServername();
     $this->username = dbCreds::getUsername();
     $this->password = dbCreds::getPassword();
     $this->dbname = dbCreds::getDbname();

    //  $this->taskName = $name;
    //  $this->taskDescription = $description;
    //  $this->taskListId = $list;
    //  $this->taskDuration = $minutes;
    //  $this->taskStatus = $status;

    }

    /**
     * adds new task to a list
     * 
     * param $name 
     */
    public function newTask($name, $description, $list_id, $minutes){
        $servername = $this->servername;
        $username = $this->username;
        $password =  $this->password;
        $dbname = $this->dbname;
        try {
            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO `Tasks`( `task_name`, `task_description`, `list_id`, `duration`) VALUES ( :taskname, :taskdescription, :listid, :minutes)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([":taskname"=>$name,
                           ":taskdescription"=>$description,
                           ":listid"=>$list_id,
                           ":minutes"=>"00:" . $minutes . ":00"]);
          }
          catch (PDOexception $e) {
              echo "Error is: " . $e->getmessage();
              die();
          }
    }

    /**
     * edit task
     * 
     */
    public function editTask($name, $description, $minutes, $id, $status){
        $servername = $this->servername;
        $username = $this->username;
        $password =  $this->password;
        $dbname = $this->dbname;
        try {
            $values = array_map ( 'htmlspecialchars' , $_POST );
            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `Tasks` SET `task_name`=:taskname,`task_description`=:description, `duration`=:duration, `status`=:status WHERE `id`= :id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([":taskname"=>$values['taskName'],
                            ":id"=>$values['taskId'],
                            ":description"=>$values['taskDescription'],
                            ":duration"=>"00:" . $values['minutes'] . ":00",
                            ":status"=>$values['status']]);
          }
          catch (PDOexception $e) {
              echo "Error is: " . $e->getmessage();
              die();
          }
    }

    public static function GetAllListTasks($list_id) {
        $servername = dbCreds::getServername();
        $username = dbCreds::getUsername();
        $password = dbCreds::getPassword();
        $dbname = dbCreds::getDbname();
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $values = array_map ( 'htmlspecialchars' , $_POST );
            $sql = 'SELECT * FROM `Tasks` WHERE `list_id` = :id AND `status`=:status ORDER BY `duration` ' . $values['duration'];
            $tasks = $dbh->prepare($sql);
            $tasks->execute([":status"=>$values['status'],
                            ":id"=>$list_id]);
        } else {
            $sql = "SELECT * FROM Tasks WHERE list_id = " . $list_id;
            $tasks = $dbh->query($sql);
      }
      return $tasks;
    }

    public function deleteTask($id){
        $servername = dbCreds::getServername();
        $username = dbCreds::getUsername();
        $password = dbCreds::getPassword();
        $dbname = dbCreds::getDbname();
        try {
            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM `Tasks` WHERE `id`=:id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([":id"=>$id]);
            }
            catch (PDOexception $e) {
                echo "Error is: " . $e->getmessage();
                die();
            }
    }
    

}
