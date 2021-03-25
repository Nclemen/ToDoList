<?php

    include 'inc/autoloader.php';

    $values = array_map ( 'htmlspecialchars' , $_POST );

    $task = new TaskModel();

    $task->newTask($values['taskName'], $values['taskDescription'], $values['listId'], $values['minutes']);

    header("Refresh:3; url=index.php");
?>

<html>
    <h1>added Task</h1>
</html>