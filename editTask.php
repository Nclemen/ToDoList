<?php

    include 'inc/autoloader.php';

    $values = array_map ( 'htmlspecialchars' , $_POST );

    $task = new TaskModel();

    $task->editTask($values['taskName'], $values['taskDescription'], $values['minutes'], $values['taskId'], $values['status']);

    header("Refresh:3; url=index.php");

?>

<html>
    <h1>Task edited</h1>
</html>