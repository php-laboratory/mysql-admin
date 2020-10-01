<?php
  include_once "connections.php";
  include_once "databases.php";

  /* Table methods */
  function createTable($mysql, $database, $table, $columns) {
    try {
      $mysql->createTable($database, $table, $columns);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function dropTable($mysql, $database, $table) {
    try {
      $mysql->dropTable($database, $table);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function copyTable($mysql, $fromDatabase, $fromTable, $toDatabase, $toTable) {
    try {
      $mysql->copyTable($fromDatabase, $fromTable, $toDatabase, $toTable);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function clearTable($mysql, $database, $table) {
    try {
      $mysql->clearTable($database, $table);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function importTable($mysql, $database, $table, $values) {
    try {
      $mysql->importTable($database, $table, $values);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function exportTable($mysql, $database, $table) {
    try {
      $filename = "$table.csv";
      $path = sys_get_temp_dir() . $filename;
      $CSVFile = fopen($path, "w");
  
      fwrite($CSVFile, convertValuesToCSV($mysql->exportTable($database, $table)));
      fclose($CSVFile);
      header("Content-type: application/csv");
      header("Content-disposition: attachment; filename=$filename");
      header("Content-Length: " . filesize($path));
      readfile($path);
      unlink($path);
      exit();
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }
  
  $mysql = $connections["mysql"];
  $selectedDatabase = $_SESSION["selected_database"];

  $tableList = array();

  if (isset($mysql) && isset($selectedDatabase)) {
    /* Action router */
    switch ($_POST["action"]) {
      case "create_table":
        $columns = array_map(function ($name, $definition) { return "$name $definition"; }, $_POST["column_name"], $_POST["column_definition"]);
        $tableError = createTable($mysql, $selectedDatabase, $_POST["name"], $columns);
        break;

      case "drop_table":
        $tableError = dropTable($mysql, $selectedDatabase, $_POST["name"]);
        break;

      case "copy_table":
        $tableError = copyTable($mysql, $selectedDatabase, $_POST["name"], $_POST["to_database"], $_POST["to_table"]);
        break;

      case "clear_table":
        $tableError = clearTable($mysql, $selectedDatabase, $_POST["name"]);
        break;

      case "import_table":
        // TODO: form values
        // $error = importTable($mysql, $selectedDatabase, $_POST["name"], $values);
        break;

      case "export_table":
        $error = exportTable($mysql, $selectedDatabase, $_POST["name"]);
        break;

      case "select_table":
        if (in_array($_POST["name"], $mysql->listTables($selectedDatabase))) {
          $_SESSION["selected_table"] = $_POST["name"];
        } else {
          unset($_SESSION["selected_table"]);
        }
        break;

      case "unselect_table":
        unset($_SESSION["selected_table"]);
        break;

      default:
        break;
    }


    foreach ($mysql->listTables($selectedDatabase) as $table) {
      $tableList[$table] = $mysql->listColumns($selectedDatabase, $table);
    }
  }

  if (isset($tableList[$_SESSION["selected_table"]])) {
    $selectedTable = $_SESSION["selected_table"];
  } else {
    unset($_SESSION["selected_table"]);
  }

  /* Tables exported variables */
  $tables = array(
    "list" => $tableList,
    "selected" => $selectedTable,
    "error" => $tableError,
  );
?>