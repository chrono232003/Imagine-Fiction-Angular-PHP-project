<?php
class Query {

  /**
   * This is a class that controlles the queries to the db.
   *
   * @return String
   */

  private $indexStories = "SELECT S.ID, S.Title, S.Story, S.ImagePath, C.Category, U.Username FROM user_stories as S INNER JOIN categories C ON S.CID = C.ID INNER JOIN users U ON S.UID = U.ID";
  private $grabAllCategories = "SELECT * FROM categories";
  private $getStory = "SELECT S.Title, S.Story, S.ImagePath, C.Category, U.Username FROM user_stories as S INNER JOIN categories C ON S.CID = C.ID INNER JOIN users U ON S.UID = U.ID";


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
    include 'connection.php';
    $query = "INSERT INTO user_stories(`Email`, `Username`, `Password`) VALUES (''$email', '$user', '$pass')";

    $result = mysqli_query($con, $query)
          or die('Could not execute login query');

          $num = (mysqli_num_rows($result));
          if ($num > 0){
            while($row = mysqli_fetch_assoc($result)) {
              echo json_encode($row);
            };
          }
  }

    public function submitStory($title, $genre, $content) {
      include 'connection.php';
      $_title = mysqli_real_escape_string($con, $title);
      $_genre = mysqli_real_escape_string($con, $genre);
      $_content = mysqli_real_escape_string($con, $content);
      $query = "INSERT INTO user_stories(`CID`, `UID`, `Title`, `Story`, `ImagePath`) VALUES ($_genre, 1, '$_title', '$_content', 'Draculasguest.jpg')";
      if (mysqli_query($con, $query)) {
        echo "Records inserted successfully.";
      } else{
        echo "ERROR: Could not execute query: " . mysqli_error($con);
      }
    }
}
?>
