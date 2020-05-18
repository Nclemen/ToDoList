<?php
 include 'inc/dbc.inc.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="container">
      <div class="row">
    <?php
    try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM Lists";
    $lists = $dbh->query($sql);
    foreach ($lists as $list) {
?>
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title"><?php echo $list['listName'] ?></h5>
<?php
      $sql2 = "SELECT * FROM Tasks WHERE list_id = " . $list['id'];
      $tasks = $dbh->query($sql2);
      foreach ($tasks as $task) {
        $taskidentifier = $task['task_name'] . $task['id'];
        ?>
        <div id="accordion<?php echo $task['id'] ?>">
        <div class="card">
        <div class="card-header" id="heading<?php echo $taskidentifier ?>">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $taskidentifier ?>" aria-expanded="true" aria-controls="collapse<?php echo $taskidentifier ?>">
              <?php echo $task['task_name'] ?>
            </button>
          </h5>
        </div>
        <div id="collapse<?php echo $taskidentifier ?>" class="collapse " aria-labelledby="heading<?php echo $taskidentifier ?>" data-parent="#accordion">
          <div class="card-body">
            <?php echo $task['task_description'] ?>
          </div>
        </div>
        <?php
        ?>
</div>
</div>
        <?php
      };
      ?>
    </div>
  </div>
      <?php
    };
    $dbh = null;
    }
    catch (PDOexception $e) {
        echo "Error is: " . $e-> etmessage();
    }
    ?>
  </div>
  </div>

  </body>
</html>
