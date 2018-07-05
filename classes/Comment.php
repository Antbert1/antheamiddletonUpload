<?php

/**
 * Class to handle articles
 */

class Comment
{
  public $id = null;
  public $publicationDate = null;
  public $userName = null;
  public $content = null;
  public $published = null;
  public $postID = null;

  public function __construct( $data=array() ) {
    if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
    if ( isset( $data['publicationDate'] ) ) $this->publicationDate = (int) $data['publicationDate'];
    if ( isset( $data['content'] ) ) {
      $this->content = $data['content'];
    }
    if ( isset( $data['published'] ) ) {
      $this->published = (int) $data['published'];
    }
    if ( isset( $data['postID'] ) ) $this->postID = (int) $data['postID'];
    if ( isset( $data['userName'] ) ) $this->userName = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['userName'] );


  }


  /**
  * Sets the object's properties using the edit form post values in the supplied array
  *
  * @param assoc The form post values
  */

  public function storeFormValues ( $params ) {
    // Store all the parameters
    $this->__construct( $params );

    // Parse and store the publication date
    if ( isset($params['publicationDate']) ) {
      $publicationDate = explode ( '-', $params['publicationDate'] );

      if ( count($publicationDate) == 3 ) {
        list ( $y, $m, $d ) = $publicationDate;
        $this->publicationDate = mktime ( 0, 0, 0, $m, $d, $y );
      }
    }
  }


  /**
  * Returns an Article object matching the given article ID
  *
  * @param int The article ID
  * @return Article|false The article object, or false if the record was not found or there was a problem
  */

  public static function getById( $id ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM comments WHERE id = :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":id", $id, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new Comment( $row );
  }


  /**
  * Returns all (or a range of) Article objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="publicationDate DESC")
  * @return Array|false A two-element array : results => array, a list of Article objects; totalRows => Total number of articles
  */

  public static function getList( $numRows=1000000, $order="publicationDate DESC" ) {

    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM comments
            ORDER BY " . mysql_escape_string($order) . " LIMIT :numRows";

    $st = $conn->prepare( $sql );
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $st->execute();
    $list = array();

    while ( $row = $st->fetch() ) {
      $comment = new Comment( $row );
      $list[] = $comment;
    }

    // Now get the total number of articles that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }

  public static function getListForPost( $postID, $numRows=1000000, $order="publicationDate DESC" ) {

    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM comments where postID = $postID
            ORDER BY id ASC LIMIT :numRows";

    $st = $conn->prepare( $sql );
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $st->execute();
    $list = array();

    while ( $row = $st->fetch() ) {
      $comment = new Comment( $row );
      $list[] = $comment;
    }


    // Now get the total number of articles that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;

    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }

  public static function getListSection( $startPoint, $numRows=1000000, $order="publicationDate DESC" ) {
    $start = $startPoint*10 - 10;
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM comments
            ORDER BY " . mysql_escape_string($order) . " LIMIT ". $start . ",". $numRows;
    $st = $conn->prepare( $sql );
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $st->execute();
    $list = array();

    while ( $row = $st->fetch() ) {
      $comment = new Comment( $row );
      $list[] = $comment;
    }

    // Now get the total number of articles that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Inserts the current Article object into the database, and sets its ID property.
  */

  public function insert() {

    // Does the Article object already have an ID?
    if ( !is_null( $this->id ) ) trigger_error ( "Comment::insert(): Attempt to insert an Comment object that already has its ID property set (to $this->id).", E_USER_ERROR );

    // Insert the Article
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO comments ( publicationDate, postID, userName, content, published ) VALUES ( FROM_UNIXTIME(:publicationDate), :postID, :userName, :content, :published )";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
    $st->bindValue( ":postID", $this->postID, PDO::PARAM_STR );
    $st->bindValue( ":userName", $this->userName, PDO::PARAM_STR );
    $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
    $st->bindValue( ":published", $this->published, PDO::PARAM_STR );
    $st->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Updates the current Article object in the database.
  */

  public function update($val) {
    echo "UPDATE";
    // Does the Article object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Article::update(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );
    if ($val == 0) {
      $val = 1;
    }
    else {
      $val = 0;
    }
    // Update the Article
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    // $sql = "UPDATE comments SET published=".$val. "WHERE id = :id";
    $sql = "UPDATE comments SET published=" . $val ." WHERE id = :id";
    echo $sql;
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

  public function delete() {
    echo "DELETE";
    // Does the Article object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Article::update(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );

    // Update the Article
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    // $sql = "UPDATE comments SET published=".$val. "WHERE id = :id";
    $sql = "DELETE FROM comments WHERE id = :id";
    echo $sql;
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Deletes the current Article object from the database.
  */
  // 
  // public function delete() {
  //
  //   // Does the Article object have an ID?
  //   if ( is_null( $this->id ) ) trigger_error ( "Comment::delete(): Attempt to delete an Comment object that does not have its ID property set.", E_USER_ERROR );
  //
  //   // Delete the Article
  //   $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  //   $st = $conn->prepare ( "DELETE FROM comments WHERE id = :id LIMIT 1" );
  //   $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
  //   $st->execute();
  //   $conn = null;
  // }

}

?>
