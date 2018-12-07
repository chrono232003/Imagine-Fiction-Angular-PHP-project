<?php
require_once("queryBase.php");
class Query extends QueryBase{

  /**
   * This is a class that controlles the queries to the db.
   *
   * @return String
   */

  //full querys
  private $indexStories = "SELECT S.ID, S.Title, S.Story, S.ImagePath, C.Category, U.Username FROM user_stories as S INNER JOIN categories C ON S.CID = C.ID INNER JOIN users U ON S.UID = U.ID";
  private $allCategories = "SELECT * FROM categories";

  //base queries
  private $storyBase = "SELECT S.Title, S.Story, S.ImagePath, C.Category, U.Username FROM user_stories as S INNER JOIN categories C ON S.CID = C.ID INNER JOIN users U ON S.UID = U.ID";
  private $storiesByCategoryBase = "SELECT S.ID, S.Title, S.Story, S.ImagePath, U.Username FROM user_stories as S INNER JOIN  users U ON S.UID = U.ID";
  private $getUserBase = "SELECT Username FROM users";
  private $verifyUserKeyBase = "SELECT VerifyKey FROM users";

  //statement getter functions
  public function getIndexStories()
  {
      return $this->simpleStatementSelectQuery($this->indexStories);
  }

  public function grabAllCategories()
  {
      return $this->simpleStatementSelectQuery($this->allCategories);
  }

  public function getStory($ID) {
      $colsToQuery = array("S.ID");
      $arrayOfParams = array($ID);
      echo $this->selectQueryWithParameters($this->storyBase, $colsToQuery, $arrayOfParams);
    }

  public function getStoriesByCategory($catID) {
    $colsToQuery = array("S.CID");
    $arrayOfParams = array($catID);
    echo $this->selectQueryWithParameters($this->storiesByCategoryBase, $colsToQuery, $arrayOfParams);
   }

  public function queryUserLogin($user, $pass) {
    $colsToQuery = array("username", "password");
    $arrayOfParams = array($user, $pass);
    echo $this->selectQueryWithParameters($this->getUserBase, $colsToQuery, $arrayOfParams);
  }

  public function queryUserKeyVerify($key) {
    $colsToQuery = array("VerifyKey");
    $arrayOfParams = array($key);
    echo $this->selectQueryWithParameters($this->verifyUserKeyBase, $colsToQuery, $arrayOfParams);
  }

public function submitUserRegistration($email, $user, $pass, $key) {
  $k = array("Email", "Username", "Password", "VerifyKey");
  $v = array($email, $user, $pass, $key);
  echo $this->insertQuery('users', $k, $v);
}

  public function submitStory($title, $genre, $content) {
    $k = array("CID", "UID", "Title", "Story", "ImagePath");
    $v = array($genre, "1", $title, $content, "TestImage.jpg");
    echo $this->insertQuery('user_stories', $k, $v);
  }
}
?>
