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
          $conditions = $conditions . "$colsToQuery[$x] = '$param' AND ";
        }
      }

      $query = $statement . " WHERE " . $conditions;
      $result = mysqli_query($con, $query);
      if ($result) {
        header('Content-Type: application/json');
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
          $rows[] = $row;
        }
        return json_encode($rows);
      }
      return json_encode("{'empty':'No Data Found'}");
    }




  public function insertQuery($tableName, $arrayOfColNames, $arrayOfValues) {
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

    $query = "INSERT INTO $tableName($colNameList) VALUES ($valueList)";
    if (mysqli_query($con, $query)) {
      return "Records inserted successfully. " . $query;
    } else{
      return "ERROR: Could not execute query: " . mysqli_error($con);
    }
  }


  //this has specific behavior therefore it is extended
  public function verifyUserQuery($statement, $colsToQuery, $arrayOfParams) {
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
        $conditions = $conditions . "$colsToQuery[$x] = '$param' AND ";
      }
    }

    $query = $statement . " WHERE " . $conditions;
    $result = mysqli_query($con, $query);
     if (mysqli_num_rows($result)!=0) {
       $value = mysqli_fetch_object($result);
      $this->activateUser($value->VerifyKey);
      header('Content-Type: application/json');
      return json_encode(array("message" => "Your account has been activated successfully. You may now login from the top of the page to write a story or comment."));
    } else {
      return json_encode(array("message" => "The user is either not found or has already registered."));
    }
  }

  //utility functions
  function activateUser($key) {
    include 'connection.php';
    $query2 = "UPDATE users SET Active = 1 WHERE VerifyKey = '$key'";
    $result2 = mysqli_query($con, $query2);
    //return $result;
  }

}

?>
