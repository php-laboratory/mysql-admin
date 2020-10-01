<?php
  include_once "mysql.php";
  
  /* Connections methods */
  function addConnection($name, $host, $username, $password) {
    if (isset($_SESSION["connections"][$name])) {
      return "connection host already exists.";
    }

    try {
      new Mysql($host, $username, $password);

      $_SESSION["connections"][$name] = array(
        "host" => $host,
        "username" => $username,
        "password" => $password
      );
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  function removeConnection($name) {
    unset($_SESSION["connections"][$name]);
  }

  session_start();

  $_SESSION["connections"] = isset($_SESSION["connections"]) ? $_SESSION["connections"] : array();

  /* Action router */
  switch ($_POST["action"]) {
    case "select_connection":
      if (isset($_SESSION["connections"][$_POST["name"]])) {
        $_SESSION["selected_connection"] = $_POST["name"];
      } else {
        unset($_SESSION["selected_connection"]);
      }
      break;

    case "add_connection":
      $connectionError = addConnection($_POST["name"], $_POST["host"], $_POST["username"], $_POST["password"]);

      if (!isset($error)) {
        $_SESSION["selected_connection"] = $_POST["name"];
      }
      break;

    case "remove_connection":
      removeConnection($_POST["name"]);

      if ($_SESSION["selected_connection"] === $_POST["name"]) {
        unset($_SESSION["selected_connection"]);
      }
      break;

    default:
      break;
  }

  $connectionList = $_SESSION["connections"];

  if (isset($_SESSION["selected_connection"])) {
    if (isset($connectionList[$_SESSION["selected_connection"]])) {
      $selectedConnection = $_SESSION["selected_connection"];
      $connection = $connectionList[$selectedConnection];

      try {
        $mysql = new Mysql($connection["host"], $connection["username"], $connection["password"]);
      } catch (Exception $e) {
        $connectionError = $e->getMessage();
      }
    } else {
      unset($_SESSION["selected_connection"]);
    }
  }

  /* Connections exported variables */
  $connections = array(
    "list" => $connectionList,
    "selected" => $selectedConnection,
    "mysql" => $mysql,
    "error" => $connectionError,
  );
?>