

<?php
require( "config.php" );
$emailError = false;

if (isset($_POST['emailAddress'])) {
  $emailAdd = $_POST['emailAddress'];
  echo $emailAdd;
  #$messageToShow = "";

  $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

  if(!preg_match($email_exp,$emailAdd)) {
    $emailError = true;
  }

  else {

    $emailMessage = "New Subscriber: " . $emailAdd."\r\n";
    @mail('hello@antheamiddleton.com', 'New Subscriber', $emailMessage);
  }
}




if (isset($_GET['postID'])) {
  if (isset($_POST['emailAddress']) && $emailError == false) {
    header("Location: post/". $_GET['postID']."?subscribed=1");
  } else if (isset($_POST['emailAddress']) && $emailError == true) {
    header("Location: post/". $_GET['postID']."?subscribed=0");
  } else {
    header("Location: post/". $_GET['postID']);
  }

} else if (isset($_GET['pageNum'])) {
  if (isset($_POST['emailAddress']) && $emailError == false) {
    header("Location: nav/page/". $_GET['pageNum']."?subscribed=1");
  } else if (isset($_POST['emailAddress']) && $emailError == true) {
    header("Location: nav/page/". $_GET['pageNum']."?subscribed=0");
  } else {
    header("Location: nav/page/". $_GET['pageNum']);
  }
}
else {
  if (isset($_POST['emailAddress']) && $emailError == false) {
    header("Location: about?subscribed=1");
  } else if (isset($_POST['emailAddress']) && $emailError == true) {
    header("Location: about?subscribed=0");
  } else {
    header("Location: about");
  }
}


//header("Location: nav/page/". $postID."?comment=1#commentAnchor");

 ?>
