<?php
 
 include 'inc/autoloader.php';

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <div class="row">
      <form action="" method="post">
        <div class="form-group">
          <label for=""></label>
          <select name="status">
            <option value="0" <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['status'] === "0") {
                  echo 'selected';
                }
               ?>>incomplete</option>
            <option value="1" <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['status'] === "1") {
                  echo 'selected';
                }
               ?>>complete</option>
          </select>
          <label for="duration">duration</label>
          <select name="duration">
            <option value="DESC" 
            <?php ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['duration'] === "DESC") ? print 'selected' : ""; ?>
            >descending</option>
            <option value="ASC" 
            <?php ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['duration'] === "ASC") ? print 'selected' : ""; ?>
            >ascending</option>
          </select>
        </div>
        <input type="submit" name="" value="submit">
      </form>
    </div>
    <div class="row">
      <?php
    foreach ($lists = ListModel::getLists() as $list) {
      $listidentifier = str_replace( [" ", "'", "\"", "&quot;"], "" ,$list['listName'] . $list['id']);
?>
      <div class="card" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title"><?php echo $list['listName'] ?>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target=".edit-list-modal-<?php echo $listidentifier ?>"><i class="fas icon-pencil"></i></button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".delete-item-modal-<?php echo $listidentifier ?>"><i class="fas icon-trash"></i></button>
          </h5>
          <?php
      $values = array_map ( 'htmlspecialchars' , $_POST );
      empty($values) ? $tasks = TaskModel::GetAllListTasks($list['id']) : $tasks = TaskModel::GetAllListTasks($list['id'], $values);
      foreach ($tasks as $task) {
        $taskidentifier = str_replace( [" ", "'", "\"", "&quot;"] , "" ,$task['task_name'] . $task['id']);
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
                  <h6><?php echo 'minutes: ' . str_replace(['00:', '00:0' ,':00'],"",$task['duration']) . ' status: ';
            switch ($task['status']) {
              case 0:
                echo 'incomplete';
                break;
              case 1:
                echo 'complete';
                break;
            }
            ?></h6>
                  <?php echo $task['task_description'] ?>
                  <div>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target=".edit-task-<?php echo $taskidentifier ?>">edit task</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".delete-item-modal-<?php echo $taskidentifier ?>">delete task</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade edit-task-<?php echo $taskidentifier ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form action="editTask.php" name="taskDescription" method="post">
                  <input type="hidden" name="taskId" value="<?php echo $task['id'] ?>">
                  <input type="hidden" name="action" value="editTask">
                  <div class="form-group">
                    <label for="taskName">task name</label>
                    <input type="text" name="taskName" value="<?php echo $task['task_name'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="taskDescription">Example textarea</label>
                    <textarea class="form-control" name="taskDescription" id="taskDescription" rows="3" maxlength="255"><?php echo $task['task_description'] ?></textarea>
                  </div>
                  <div class="form-group">
                    <h5>duration</h5>
                    <label for="minutes">minutes</label>
                    <input type="number" name="minutes" min="00" max="60" value="<?php echo str_replace(['00:', '00:0' ,':00'],"",$task['duration']) ?>">
                  </div>
                  <div class="form-group">
                    <label for="status">status</label>
                    <select name="status">
                      <option value="0" <?php
                      if ($task['status' === 0]) {
                        echo 'selected';
                      }
                     ?>>incomplete</option>
                      <option value="1" <?php
                    if ($task['status' === 0]) {
                      echo 'selected';
                    }
                    ?>>complete</option>
                    </select>
                  </div>
                  <input type="submit">
                </form>
              </div>
            </div>
          </div>
          <div class="modal fade delete-item-modal-<?php echo $taskidentifier ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Are you sure you want to delete this task?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="delete.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $task['id'] ?>">
                    <input type="hidden" name="table" value="Tasks">
                    <input type="submit" name="action" value="delete">
                  </form>
                </div>
              </div>
            </div>
          </div>
          <?php
      };
      ?>
          <div class="card">
            <div class="card-header" id="">
              <h5 class="mb-0">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".new-task-<?php echo $list['id'] ?>">add task</button>
              </h5>
            </div>
          </div>
          <div class="modal fade new-task-<?php echo $list['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <h1>New task</h1>
                <form action="addTask.php" name="taskDescription" method="post">
                  <input type="hidden" name="listId" value="<?php echo $list['id'] ?>">
                  <input type="hidden" name="action" value="addTask">
                  <div class="form-group">
                    <label for="taskName">task name</label>
                    <input type="text" name="taskName">
                  </div>
                  <div class="form-group">
                    <label for="taskDescription">task description</label>
                    <textarea class="form-control" name="taskDescription" id="taskDescription" rows="3" maxlength="255"></textarea>
                  </div>
                  <div class="form-group">
                    <h5>duration</h5>
                    <label for="minutes">minutes</label>
                    <input type="number" name="minutes" min="00" max="60" value="0">
                  </div>
                  <input type="submit">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade edit-list-modal-<?php echo $listidentifier ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="editList.php" method="post">
              <input type="hidden" name="action" value="editList">
              <input type="hidden" name="id" value="<?php echo $list['id'] ?>">
              <label for="listName">list name</label>
              <input type="text" name="listName" value="<?php echo $list['listName'] ?>">
              <input type="submit">
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade delete-item-modal-<?php echo $listidentifier ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="delete.php" method="post">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?php echo $list['id'] ?>">
              <input type="hidden" name="table" value="Lists">
              <input class="btn btn-danger" type="submit" value="delete">
            </form>
          </div>
        </div>
      </div>
      <?php
    };
    ?>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-new-list-modal">add new list</button>

      <div class="modal fade bd-new-list-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="addList.php" method="post">
              <input type="hidden" name="action" value="addList">
              <label for="listName">list name</label>
              <input type="text" name="listName">
              <input type="submit">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
