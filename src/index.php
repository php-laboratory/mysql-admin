<?php
  include_once "includes/utils.php";
  include_once "includes/mysql.php";
  include_once "includes/connections.php";
  include_once "includes/databases.php";
  include_once "includes/tables.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>MySQL Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      body {
        margin: 0px;
        font-family: ProximaNova, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      }
    </style>
    <script src="assets/utils.js"></script>
  </head>
  <body>
  <?php include_once "includes/components/dialog.php"; ?>
  <?php include_once "includes/components/prompt-dialog.php"; ?>
  <?php include_once "includes/components/confirm-dialog.php"; ?>
  <?php include_once "includes/components/create-table-dialog.php"; ?>
  <?php include_once "includes/components/file-selector.php"; ?>
  <?php include_once "includes/components/alert.php"; ?>
  <?php include_once "includes/components/connection-tab.php"; ?>
  <?php
    if (!isset($connections["selected"])) {
      include_once "includes/pages/connection.php";
    } else if (!isset($databases["selected"])) {
      include_once "includes/pages/databases.php";
    } else {
      include_once "includes/pages/tables.php";
    }
  ?>
  </body>
</html>