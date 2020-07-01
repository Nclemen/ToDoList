<?php

include 'inc/dbc.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
try {
  $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $values = array_map ( 'htmlspecialchars' , $_POST );
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO `Tasks`( `task_name`, `task_description`, `list_id`, `duration`) VALUES ( :taskname, :taskdescription, :listid, :minutes)";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([":taskname"=>$values['taskName'],
                 ":taskdescription"=>$values['taskDescription'],
                 ":listid"=>$values['listId'],
                 ":minutes"=>"00:" . $values['minutes'] . ":00"]);
  var_dump($sql);
}
catch (PDOexception $e) {
    echo "Error is: " . $e->getmessage();
}
}

// var_dump("00:" . $values['minutes'] . ":00");
//
//
// header("Location: index.php");
// die();
