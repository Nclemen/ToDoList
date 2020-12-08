<?php

try {
$dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $values = array_map ( 'htmlspecialchars' , $_POST );
  if ($values['action'] === 'addTask') {
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO `Tass`( `task_name`, `task_description`, `list_id`) VALUES ( :taskname, :taskdescription, :listid)";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([":taskname"=>$values['taskName'],
                 ":taskdescription"=>$values['taskDescription'],
                 ":listid"=>$values['listId']]);
} elseif ($values['action'] === 'addList'){
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO Lists (listName)
  VALUES (:listname)";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([":listname"=>$values['listName']]);
} elseif ($values['action'] === 'editTask') {
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "UPDATE `Tasks` SET `task_name`=:taskname,`task_description`=:description WHERE `id`= :id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([":taskname"=>$values['taskName'],
                  ":id"=>$values['taskId'],
                  ":description"=>$values['taskDescription']]);
} elseif ($values['action'] === 'editList') {
  echo 'editing list';
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "UPDATE `Lists` SET `listName`=:listname WHERE `id`= :id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([":listname"=>$values['listName'],
                  ":id"=>$values['id']]);
} elseif ($values['action'] === 'delete') {
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  switch ($values['table']) {
    case 'Tasks':
      $sql = "DELETE FROM `Tasks` WHERE `id`=:id";
      break;
    case 'Lists':
      $sql = "DELETE FROM `Lists` WHERE `id`=:id";
      break;
  }
  $stmt = $dbh->prepare($sql);
  $stmt->execute([":id"=>$values['id']]);
}
}
}
catch (PDOexception $e) {
    echo "Error is: " . $e->getmessage();
}
