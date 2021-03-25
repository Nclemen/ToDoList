<?php
    include 'inc/autoloader.php';
    $values = array_map ( 'htmlspecialchars' , $_POST );

    $list = new ListModel();

    $list->newList($values['listName']);

    header("Refresh:3; url=index.php");
?>

<html>
    <h1>added list</h1>
</html>