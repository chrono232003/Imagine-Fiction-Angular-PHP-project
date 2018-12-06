<?php
class Query {

  /**
   * This is a class that controlles the queries to the db.
   *
   * @return String
   */

  private $indexStories = "SELECT S.ID, S.Title, S.Story, S.ImagePath, C.Category, U.Username FROM user_stories as S INNER JOIN categories C ON S.CID = C.ID INNER JOIN users U ON S.UID = U.ID";
  private $grabAllCategories = "SELECT * FROM categories";
  private $getStoryBase = "SELECT S.Title, S.Story, S.ImagePath, C.Category, U.Username FROM user_stories as S INNER JOIN categories C ON S.CID = C.ID INNER JOIN users U ON S.UID = U.ID";


  //statement getter functions
  public function getIndexStories()
  {
      return $this->indexStories;
  }

  public function getGrabAllCategories()
  {
      return $this->grabAllCategories;
  }

  //query functions
  public function selectQuery($statement) {
        include 'connection.php';
        $result = mysqli_query($con, $statement);

        header('Content-Type: application/json');
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
        	$rows[] = $row;
        }
        return json_encode($rows);

    }

    public function getStory($ID) {
          include 'connection.php';
          $result = mysqli_query($con, "SELECT S.Title, S.Story, S.ImagePath, C.Category, U.Username FROM user_stories as S INNER JOIN categories C ON S.CID = C.ID INNER JOIN users U ON S.UID = U.ID WHERE S.ID = '$ID'");

          header('Content-Type: application/json');
          $rows = array();
          while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
          }
          return json_encode($rows);

      }

      public function getStoriesByCategory($catID) {
            include 'connection.php';
            $result = mysqli_query($con, "SELECT S.ID, S.Title, S.Story, S.ImagePath, U.Username FROM user_stories as S INNER JOIN  users U ON S.UID = U.ID WHERE S.CID = " . $catID);

            header('Content-Type: application/json');
            $rows = array();
            while ($row = mysqli_fetch_assoc($result)) {
              $rows[] = $row;
            }
            return json_encode($rows);
          }

    public function queryUserLogin($user, $pass) {
      include 'connection.php';
      $query = "SELECT Username FROM users WHERE username = '$user' and password = '$pass'";
      $result = mysqli_query($con, $query)
      			or die('Could not execute login query');

      			$num = (mysqli_num_rows($result));
      			if ($num > 0){
      				while($row = mysqli_fetch_assoc($result)) {
      					echo json_encode($row);
      				};
      			}
    }

  public function submitUserRegistration($email, $user, $pass) {
    $k = array("Email", "Username", "Password");
    $v = array($email, $user, $pass);
    echo $this->insertQuery($k, $v);
  }

    public function submitStory($title, $genre, $content) {
      $k = array("CID", "UID", "Title", "Story", "ImagePath");
      $v = array($genre, "1", $title, $content, "TestImage.jpg");
      echo $this->insertQuery($k, $v);
    }

    /*
     * below are base queries used as models.
     * the form queries can effectively use these in their methods.
     */

    private function insertQuery($arrayOfColNames, $arrayOfValues) {
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
