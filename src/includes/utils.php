<?php
  function convertValuesToCSV($values, $delimiter = ",", $enclosure = "\"") {
    $encloseValue = function ($value) use ($enclosure) {
      return $enclosure . $value . $enclosure;
    };
    $encloseRow = function ($row) use ($encloseValue) {
      return array_map($encloseValue, $row);
    };

    $getColumnNames = function ($values) {
      $columnNames = array();
  
      if (count($values) > 0) {
        foreach ($values[0] as $columnName => $value) {
          array_push($columnNames, $columnName);
        }
      }
  
      return $columnNames;
    };
  
    $getRows = function ($values) {
      $rows = array();
  
      foreach ($values as $rowIndex => $valueRow) {
        $row = array();
  
        foreach ($valueRow as $columnName => $value) {
          array_push($row, $value);
        }
  
        array_push($rows, $row);
      }
  
      return $rows;
    };

    $columnNames = array_map($encloseValue, $getColumnNames($values));
    $rows = array_map($encloseRow, $getRows($values));

    $content = array();

    array_push($content, join($delimiter, $columnNames));

    foreach ($rows as $row) {
      array_push($content, join($delimiter, $row));
    }

    return join("\r\n", $content);
  }

  function convertCSVToValues($CSV, $delimiter = ",", $enclosure = "\"") {
    $discloseValue = function ($value) {
      return preg_replace("/^\s*\"|\"\s*$/", "", $value);
    };

    $results = array();
    $columnNames = array();

    $lines = preg_split("/\r\n|\n/", $CSV);
  
    for ($i = 0; $i < count($lines); $i++) {
      $lineValues = explode($delimiter, $lines[$i]);

      if (count($lineValues) > 1) {
        if ($i === 0) {
          $columnNames = array_map($discloseValue, $lineValues);
        } else {
          $rowValues = array_map($discloseValue, $lineValues);

          $values = array();

          for ($j = 0; $j < count($columnNames); $j++) {
            $values[$columnNames[$j]] = $rowValues[$j];
          }

          array_push($results, $values);
        }
      }
    }

    return $results;
  }
?>