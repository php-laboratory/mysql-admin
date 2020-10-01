<?php
  include_once "connections.php";

  /* Databases methods */
  function selectDatabase($mysql, $name) {
    try {
      $mysql->selectDatabase($name);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function createDatabase($mysql, $name) {
    try {
      $mysql->createDatabase($name);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function dropDatabase($mysql, $name) {
    try {
      $mysql->dropDatabase($name);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function importDatabase($mysql, $name) {
    
  }

  function exportDatabase($mysql, $name) {
    try {
      $tables = $mysql->listTables($name);

      $filename = "$name.zip";
      $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;
      $zip = new ZipArchive;
      $zip->open($path, ZipArchive::CREATE);

      foreach ($tables as $table) {
        $zip->addFromString("$table.csv", convertValuesToCSV($mysql->exportTable($name, $table)));
      }

      $success = $zip->close();

      if ($success) {
        header("Content-Type: application/zip");
        header("Content-disposition: attachment; filename=$filename");
        header("Content-Length: " . filesize($path));
        readfile($path);
        unlink($path);
        exit();
      } else {
        throw new Exception("Creating zip file failed");
      }
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function copyDatabase($mysql, $from, $to) {
    try {
      $mysql->copyDatabase($from, $to);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function clearDatabase($mysql, $name) {
    try {
      $mysql->clearDatabase($name);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  $mysql = $connections["mysql"];

  $databaseList = array();

  if (isset($mysql)) {
    /* Action router */
    switch ($_POST["action"]) {
      case "select_database":
        if (isset($_POST["name"])) {
          $databaseError = selectDatabase($mysql, $_POST["name"]);
        
          if (!$databaseError) {
            $_SESSION["selected_database"] = $_POST["name"];
          }
        }

        if (!isset($_POST["name"]) || $databaseError) {
          unset($_SESSION["selected_database"]);
        }
        break;

      case "create_database":
        $databaseError = createDatabase($mysql, $_POST["name"]);
        break;

      case "drop_database":
        $databaseError = dropDatabase($mysql, $_POST["name"]);

        if ($_SESSION["selected_database"] === $_POST["name"]) {
          unset($_SESSION["selected_database"]);
        }
        break;

      case "export_database":
        $databaseError = exportDatabase($mysql, $_POST["name"]);
        break;
      
      case "copy_database":
        $databaseError = copyDatabase($mysql, $_POST["name"], $_POST["copy_to"]);
        break;

      case "clear_database":
        $databaseError = clearDatabase($mysql, $_POST["name"]);
        break;

      default:
        break;
    }

    foreach ($mysql->listDatabases() as $database) {
      $databaseList[$database] = $mysql->listTables($database);
    }
  }

  if (isset($databaseList[$_SESSION["selected_database"]])) {
    $selectedDatabase = $_SESSION["selected_database"];
  } else {
    unset($_SESSION["selected_database"]);
  }

  /* Databases exported variables */
  $databases = array(
    "list" => $databaseList,
    "selected" => $selectedDatabase,
    "error" => $databaseError,
  );
?>