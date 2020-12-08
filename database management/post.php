<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
} else {
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>test</title>
  </head>
  <body>
    <form action="" method="post">

        <label for="duration[hours]">hours</label>
        <input type="number" name="duration[hours]" min="0" value="0">
        <label for="duration[minutes]">minutes</label>
        <input type="number" name="duration[minutes]" min="0" max="60" value="0">
        <label for="duration[seconds]">seconds</label>
        <input type="number" name="duration[seconds]" min="0" max="60" value="0">

        <input type="submit">
    </form>
  </body>
</html>
<?php
}
?>
