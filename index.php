<?php

require( "config.php" );
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

$catAll = false;
if (isset($_GET['category'])) {
  $catAll = $_GET['category'];
}
switch ( $action ) {
  case 'archive':
    archive();
    break;
  case 'about':
    about();
    break;
  case 'post':
    viewArticle();
    break;
  case 'page':
    viewListSection();
    break;
  case 'category':
    if ($catAll == 'All') {
      homepage();
    }
    else {
      viewCatSection();
    }
    break;
  default:
    homepage();
}


function archive() {
  $results = array();
  $data = Article::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Article Archive | Anthea Middleton";
  require( TEMPLATE_PATH . "/archive.php" );
}

function about() {
  $results = array();
  $results['pageTitle'] = "About | Anthea Middleton";
  require( TEMPLATE_PATH . "/about.php" );
}

function viewArticle() {
  if ( !isset($_GET["articleId"]) || !$_GET["articleId"] ) {
    homepage();
    return;
  }

  $results = array();
  $results['article'] = Article::getById( (int)$_GET["articleId"] );
  $results['comments'] = Comment::getListForPost( (int)$_GET["articleId"] )['results'];
  $results['pageTitle'] = $results['article']->title . " | Anthea Middleton";
  $results['previous'] =  Article::getPrev( (int)$_GET["articleId"]-1 );
  $results['next'] =  Article::getNext( (int)$_GET["articleId"]+1 );
  //echo sizeof($results['comments']);
  require( TEMPLATE_PATH . "/viewArticle.php" );
}

function viewListSection() {
  $resultsCats = array();
  $categories = array();
  $newCats = array();

  $startPoint = $_GET["startPoint"];
  $results = array();
  $data = Article::getListSection( $startPoint, HOMEPAGE_NUM_ARTICLES );
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Anthea Middleton";
  $data2 = Article::getList();
  $resultsCats['articlesAll'] = $data2['results'];
  // $categories = Article::getCats();
  // $results2 = $categories['cats'];
  //GET ALL ARTICLES INSTEAD OF TEN
  foreach ($resultsCats['articlesAll'] as $article) {
    array_push($categories, $article->categories);
  }

  foreach($categories as $cat) {
    $exploded = explode(",", $cat);
    foreach ($exploded as $individualCat) {
      array_push($newCats, ucfirst(trim($individualCat)));
    }
  }

  $newCatsUnique = array_unique($newCats);
  sort($newCatsUnique);
  array_unshift($newCatsUnique, "All");
  require( TEMPLATE_PATH . "/homepage.php" );
}

function viewCatSection() {
  $results = array();
  $category = $_GET["category"];

  if ($category == 'All') {
    homepage();
    return;
  }

  $resultsCats = array();
  $categories = array();
  $newCats = array();
  $data = Article::getCatList($category);
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Anthea Middleton";

  $data2 = Article::getList();
  $resultsCats['articlesAll'] = $data2['results'];
  // $categories = Article::getCats();
  // $results2 = $categories['cats'];
  //GET ALL ARTICLES INSTEAD OF TEN
  foreach ($resultsCats['articlesAll'] as $article) {
    array_push($categories, $article->categories);
  }

  foreach($categories as $cat) {
    $exploded = explode(",", $cat);
    foreach ($exploded as $individualCat) {
      array_push($newCats, ucfirst(trim($individualCat)));
    }
  }

  $newCatsUnique = array_unique($newCats);
  sort($newCatsUnique);
  array_shift($newCatsUnique);
  array_unshift($newCatsUnique, "All");

  require( TEMPLATE_PATH . "/homepage.php" );
}

function homepage() {
  $results = array();
  $resultsCats = array();
  $categories = array();
  $newCats = array();
  // $results2 = array();
  $data = Article::getList( HOMEPAGE_NUM_ARTICLES );
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Anthea Middleton";

  $data2 = Article::getList();
  $resultsCats['articlesAll'] = $data2['results'];
  // $categories = Article::getCats();
  // $results2 = $categories['cats'];
  //GET ALL ARTICLES INSTEAD OF TEN
  foreach ($resultsCats['articlesAll'] as $article) {
    array_push($categories, $article->categories);
  }

  foreach($categories as $cat) {
    $exploded = explode(",", $cat);
    foreach ($exploded as $individualCat) {
      array_push($newCats, ucfirst(trim($individualCat)));
    }
  }

  $newCatsUnique = array_unique($newCats);
  sort($newCatsUnique);
  //echo '*'.$newCatsUnique[1 ].'*';
  array_shift($newCatsUnique);
  array_unshift($newCatsUnique, "All");


  require( TEMPLATE_PATH . "/homepage.php" );
}

?>
