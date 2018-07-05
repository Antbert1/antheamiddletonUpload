
 <?php
 require( "config.php" );

 $postID = $_GET['postID'];

 $commentVals = $_POST;
 $commentVals['postID'] = $postID;
 $commentVals['published'] = 'FALSE';
 $commentVals['publicationDate'] = date("Y-m-d");


 //CHECK CAPTCHA
 if(isset($_POST['g-recaptcha-response'])){
   $captcha=$_POST['g-recaptcha-response'];
 }
 if(!$captcha){
   echo '<h2>Invalid Captcha Response. Try again.</h2>';
   exit;
 }
 $secretKey = "6LdtImIUAAAAAPiRZAYiu7eHIk6Tt8oorutmcGlm";
 $ip = $_SERVER['REMOTE_ADDR'];
 $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
 $responseKeys = json_decode($response,true);
 if(intval($responseKeys["success"]) !== 1) {
   echo '<h2>Invalid Captcha Response. Try again.</h2>';
 }
 else {
   //Only do this if Captcha is valid
   newComment($commentVals);
   header("Location: post/". $postID."?comment=1#commentAnchor");
 }


 function newComment($commentVals) {
     // User has posted the article edit form: save the new article
     $comment = new Comment;
     $comment->storeFormValues( $commentVals );
     $comment->insert();

 }
