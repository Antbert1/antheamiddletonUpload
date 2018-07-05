<?php
ini_set( "display_errors", false );
date_default_timezone_set( "Europe/London" );  // http://www.php.net/manual/en/timezones.php
define( "DB_DSN", "mysql:host=localhost;dbname=a559959_antheamiddleton" );
define( "DB_USERNAME", "a559959_anthea" );
define( "DB_PASSWORD", "5qTm=?sCUb1]" );
define( "CLASS_PATH", "classes" );
define( "TEMPLATE_PATH", "templates" );
define( "HOMEPAGE_NUM_ARTICLES", 10 );
define( "ADMIN_USERNAME", "admin" );
define( "ADMIN_PASSWORD", "mypass" );
//define( "ADMIN_PASSWORD", "$2y$10$KfKIcQbd3/0x5VhLrnd3.OqNHO2udkrkLyUW3nFvKvOq/OnAVP32a" );
//TODO: Hash the password - "$2y$10$KfKIcQbd3/0x5VhLrnd3.OqNHO2udkrkLyUW3nFvKvOq/OnAVP32a"
require( CLASS_PATH . "/Article.php" );
require( CLASS_PATH . "/Comment.php" );

function handleException( $exception ) {
  echo "Sorry, a problem occurred. Please try later.";
  echo $exception->getMessage();
  error_log( $exception->getMessage() );
}

set_exception_handler( 'handleException' );
?>
