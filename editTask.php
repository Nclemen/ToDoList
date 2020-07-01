<?php

include 'inc/dbc.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
}
}


header("Location: index.php");
die();
