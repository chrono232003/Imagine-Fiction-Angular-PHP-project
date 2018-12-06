<?php

class QueryBase {

  public function simpleStatementSelectQuery($statement) {
        include 'connection.php';
        $result = mysqli_query($con, $statement);

        header('Content-Type: application/json');
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
          $rows[] = $row;
        }
        return json_encode($rows);

    }

    public function selectQueryWithParameters($statement, $colsToQuery, $arrayOfParams) {
      include 'connection.php';
      $conditions = "";

      //loop through array col names and params and condition to add to the insertion query. The loop goes from the value list but both lists should be same size.
      $arrLength = count($arrayOfParams);
      for ($x = 0; $x < $arrLength; $x++) {

        //condition value and store to variable
        $param = mysqli_real_escape_string($con,$arrayOfParams[$x]);

        if(($x + 1) == $arrLength) {
          $conditions = $conditions . "$colsToQuery[$x] = '$param'";
        } else {
          $conditions = $conditions . "$colsToQuery[$x] = '$param' AND";
        }
      }

      $query = $statement . " WHERE " . $conditions;
      $result = mysqli_query($con, $query);

      header('Content-Type: application/json');
      $rows = array();
      while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
      }
      return json_encode($rows);
    }




  public function insertQuery($arrayOfColNames, $arrayOfValues) {
    include 'connection.php';

    $colNameList = "";
    $valueList = "";

    //loop through array col names and values and condition to add to the insertion query. The loop goes from the value list but both lists should be same size.
    $arrLength = count($arrayOfValues);
    for ($x = 0; $x < $arrLength; $x++) {

      //condition value and store to variable
      $value = mysqli_real_escape_string($con,$arrayOfValues[$x]);

      if(($x + 1) == $arrLength) {
        $colNameList = $colNameList . "`$arrayOfColNames[$x]`";
        $valueList = $valueList . "'$value'";
      } else {
        $colNameList = $colNameList . "`$arrayOfColNames[$x]`" . ",";
        $valueList = $valueList . "'$value'" . ",";
      }
    }

    $query = "INSERT INTO user_stories($colNameList) VALUES ($valueList)";
    if (mysqli_query($con, $query)) {
      return "Records inserted successfully. " . $query;
    } else{
      return "ERROR: Could not execute query: " . mysqli_error($con);
    }
  }

}

?>
