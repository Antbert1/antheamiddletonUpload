<?php
require( "config.php" );
session_start();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

if ( $action != "login" && $action != "logout" && !$username ) {
  login();
  exit;
}

switch ( $action ) {
  case 'login':
    login();
    break;
  case 'logout':
    logout();
    break;
  case 'newArticle':
    newArticle();
    break;
  case 'editArticle':
    editArticle();
    break;
  case 'deleteArticle':
    deleteArticle();
    break;
  case 'toggleComment':
    toggleComment();
    break;
  case 'deleteComment':
    deleteComment();
    break;
  default:
    listArticles();
}


function login() {


  $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  $sql = "SELECT * FROM biscuits";
  $biscuit = $conn->query($sql);
  $biscuit->bindValue( ":id", 1, PDO::PARAM_INT );
  $biscuit->execute();
  $row = $biscuit->fetch();
  $biscuitVal = $row["type"];
      // output data of each row


  $conn = null;
  /*$st = $conn->prepare( $sql );
  $st->bindValue( ":id", $id, PDO::PARAM_INT );
  $st->execute();
  $row = $st->fetch();
  $conn = null;
  if ( $row ) return new Article( $row );*/


  $results = array();
  $results['pageTitle'] = "Admin Login | Anthea Middleton";

  //TODO: Hash the password
  //$ippw = $_POST['password'];


  if ( isset( $_POST['login'] ) ) {
    $enteredPassword = $_POST['password'];
    //$hashed = password_hash($biscuitVal, PASSWORD_BCRYPT);
    //echo password_verify($enteredPassword, $biscuitVal) ? 'password correct' : 'passwword incorrect';
    // User has posted the login form: attempt to log the user in

    //if ( $_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD ) {
    if ( $_POST['username'] == ADMIN_USERNAME && password_verify($enteredPassword, $biscuitVal)) {
      // Login successful: Create a session and redirect to the admin homepage
      $_SESSION['username'] = ADMIN_USERNAME;
      header( "Location: admin.php" );

    } else {

      // Login failed: display an error message to the user
      $results['errorMessage'] = "Incorrect username or password. Please try again.";
      require( TEMPLATE_PATH . "/admin/loginForm.php" );
    }

  } else {

    // User has not posted the login form yet: display the form
    require( TEMPLATE_PATH . "/admin/loginForm.php" );
  }

}


function logout() {
  unset( $_SESSION['username'] );
  header( "Location: admin.php" );
}


function newArticle() {

  $results = array();
  $results['pageTitle'] = "New Article";
  $results['formAction'] = "newArticle";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the article edit form: save the new article
    $article = new Article;
    $article->storeFormValues( $_POST );
    $article->insert();
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the article list
    header( "Location: admin.php" );
  } else {

    // User has not posted the article edit form yet: display the form
    $results['article'] = new Article;
    require( TEMPLATE_PATH . "/admin/editArticle.php" );
  }

}


function editArticle() {

  $results = array();
  $results['pageTitle'] = "Edit Article";
  $results['formAction'] = "editArticle";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the article edit form: save the article changes

    if ( !$article = Article::getById( (int)$_POST['articleId'] ) ) {
      header( "Location: admin.php?error=articleNotFound" );
      return;
    }

    $article->storeFormValues( $_POST );
    $article->update();
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the article list
    header( "Location: admin.php" );
  } else {

    // User has not posted the article edit form yet: display the form
    $results['article'] = Article::getById( (int)$_GET['articleId'] );
    require( TEMPLATE_PATH . "/admin/editArticle.php" );
  }

}

function toggleComment() {
  echo "Toggle comment function";
  $comment = Comment::getById( (int)$_GET['commentId'] );
  $value = (int)$_GET['val'];

  $comment->update($value);
  header( "Location: admin.php" );
}

function deleteComment() {
  $comment = Comment::getById( (int)$_GET['commentId'] );
  $comment->delete();
  header( "Location: admin.php" );
}


function deleteArticle() {

  if ( !$article = Article::getById( (int)$_GET['articleId'] ) ) {
    header( "Location: admin.php?error=articleNotFound" );
    return;
  }

  $article->delete();
  header( "Location: admin.php?status=articleDeleted" );
}


function listArticles() {
  $results = array();
  $data = Article::getList();
  $data2 = Comment::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "All Articles";
  $results['comments'] = $data2['results'];


  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "articleNotFound" ) $results['errorMessage'] = "Error: Article not found.";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
    if ( $_GET['status'] == "articleDeleted" ) $results['statusMessage'] = "Article deleted.";
  }

  require( TEMPLATE_PATH . "/admin/listArticles.php" );
}

?>
