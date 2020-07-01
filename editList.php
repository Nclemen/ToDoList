<?php

include 'inc/dbc.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
try {
  $values = array_map ( 'htmlspecialchars' , $_POST );
  $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "UPDATE `Lists` SET `listName`=:listname WHERE `id`= :id";
  $stmt = $dbh->prepare($sql);
  $stmt->execute([":listname"=>$values['listName'],
                  ":id"=>$values['id']]);
}
catch (PDOexception $e) {
    echo "Error is: " . $e->getmessage();
}
}


header("Location: index.php");
die();
