<?php

include 'inc/autoloader.php';
/*
 * deletes a list or a task
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$values = array_map ( 'htmlspecialchars' , $_POST );

switch ($values['table']) {
  case 'Tasks':
    $task = new TaskModel();
    $task->deleteTask($values['id']);
    echo 'you have deleted a task';
    break;
  case 'Lists':
    $list = new ListModel();
    $list->deleteList($values['id']);
    echo 'you have deleted a list';
    break;
}

}
header("Refresh:3; url=index.php");


?>
