<?php
class Query {

  /**
   * This is a VO class that simply holds the queries to be called.
   *
   * @return String
   */

  private $indexStories = "SELECT S.Title, S.Story, S.ImagePath, C.Category, U.Username FROM user_stories as S INNER JOIN categories C ON S.CID = C.ID INNER JOIN users U ON S.UID = U.ID";
  private $grabAllCategories = "SELECT Category FROM categories";

  //user query variables
  private $user;
  private $pass;

   //user query construct
   public function __construct($user, $pass) (
      $this->user = $user;
      $this->pass = $pass;
     )

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

    //statement getter functions
    public function getIndexStories()
    {
        return $this->indexStories;
    }

    public function getGrabAllCategories()
    {
        return $this->grabAllCategories;
    }

}
?>
