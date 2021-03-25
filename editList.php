<?php

    include 'inc/autoloader.php';


    $values = array_map ( 'htmlspecialchars' , $_POST );

    $list = new ListModel();

    $list->editList($values['listName'], $values['id']);


    header("Refresh:3; url=index.php");

?>

<html>
    <h1>List edited</h1>
</html>