<?php

include 'inc/dbc.inc.php';
/*
 * deletes a list or a task
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
try {
$dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$values = array_map ( 'htmlspecialchars' , $_POST );
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

var_dump($sql);
}
catch (PDOexception $e) {
    echo "Error is: " . $e->getmessage();
    die();
}
}

switch ($values['table']) {
  case 'Tasks':
    $msg = 'you have deleted' . ' a task';
    break;
  case 'Lists':
    $msg = 'you have deleted' . ' a list';
    break;
}
header("Location: index.php");

?>
