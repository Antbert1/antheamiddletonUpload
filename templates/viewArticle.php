<?php include "include/header.php";
$subscribed = 'NOTSET';
if (isset($_GET['subscribed'])) {
  if ($_GET['subscribed'] == 1) {
    $subscribed = 'true';
  }
  elseif ($_GET['subscribed'] == 0) {
    $subscribed = 'false';
  }
}
$commentVal = 0;
if(isset($_GET['comment'])) {
  $commentVal = 1;
}

$commentCount = 0;

if ( sizeof($results['comments']) > 0 ) {
  foreach ( $results['comments'] as $comment ) {
    if ($comment->published == 1) {
      $commentCount = $commentCount + 1;
      break;
    }
  }
}
?>

<section class="blogPost">


  <div class="container">
    <div class="row postTitle">
      <div class="col-md-12">
        <h1><?php echo htmlspecialchars( $results['article']->title )?></h1>
        <div class="postInfo">
          <div class="pubDate postInfoDiv"><i class="far fa-calendar-alt"></i>&nbsp;<?php echo date('j F Y', $results['article']->publicationDate)?></div>
          <div class="commentOption postInfoDiv"><a href="#commentAnchor"><i class="far fa-comment"></i>&nbsp;Leave a Comment</a></div>
          <div class"catList postInfoDiv"><i class="far fa-folder-open"></i>&nbsp;<?php echo $results['article']->categories?></div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 blog-content-row">
        <div class="nextPrevBtns">
          <?php if ($results['previous'] !== null): ?>
            <div class="prev navButtons">
              <a href="<?php echo $extension ?>post/<?php echo $results['previous']?>">&lt; Previous</a>
            </div>
          <?php else: ?>
            <div class="prev">
              <div class="spacer"></div>
            </div>
          <?php endif; ?>
          <?php if ($results['next'] !== null): ?>
            <div class="next navButtons">
              <a href="<?php echo $extension ?>post/<?php echo $results['next']?>">Next &gt;</a>
            </div>
          <?php else: ?>
            <div class="next">
              <div class="spacer"></div>
            </div>
          <?php endif; ?>

        </div>
        <?php echo $results['article']->content?>
        <div class="shareSection">
          <div class="sharethis-inline-share-buttons"></div>
          <!-- <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> -->
        </div>
        <div class="commentSection">
          <a name="commentAnchor">
            <h2>Leave a Comment</h2>
          </a>
          <form name="contactform" method="post" action="../comment.php?postID=<?php echo $results['article']->id?>">
            <div class="messages"></div>
            <div class="controls">

              <div class="form-group">
                <label for="userName">Name</label>
                <input id="form_name" type="text" name="userName" maxlength="50" size="30" class="form-control" placeholder="Enter your name *" required="required" data-error="Firstname is required.">
                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group">
                <label for="content">Comment</label>
                <textarea id="form_message" name="content" maxlength="1000" cols="25" rows="6" class="form-control" placeholder="Type message here *" rows="4" required="required" data-error="Please,leave us a message."></textarea>
                <div class="help-block with-errors"></div>
              </div>
              <div class="g-recaptcha" data-sitekey="6LdtImIUAAAAAJi7OwcqvRxZCXtbvLLqgoGdV0ci"></div>
    <!--
              <div class="g-recaptcha" data-sitekey="6LfjePkSAAAAALAHmBmSN1B2EO_qtDAOskpliwTJ"></div> -->
            <input type="submit" class="btn btn-success btn-send comment-btn" value="Submit">
            </div>
          </form>


          <?php if ( $commentVal == 1 ): ?>
            <div class="commentThanks">
              Thank you for your comment. It is awaiting validation. Aren't we all.
            </div>
          <?php endif; ?>
        </div>
        <?php if ( $commentCount > 0 ) { ?>
          <div class="commentRow">
              <h2>Comments</h2>
              <?php foreach ( $results['comments'] as $comment ) { ?>
                <?php if ( $comment->published == 1): ?>
                <div class="commentDiv">
                  <div class="commentTopRow">
                    <h3>
                      <?php echo $comment->userName ?>
                    </h3>
                    <div class="commentDate">
                      <?php echo date('j F Y', $comment->publicationDate)?>
                    </div>
                  </div>
                  <?php echo $comment->content?>
                </div>
                <?php endif; ?>
              <?php } ?>
            </div>
        <?php } ?>
      </div>
      <div class="col-md-4 RHSSection">
        <div class="subscribe">
          <h3>Subscribe</h3>
          Subscribe to my blog for email updates on new posts.
          <form name="subscribeform" method="post" action="../subscribe.php?postID=<?php echo $results['article']->id?>">
            <div class="controls">

              <div class="form-group">
                <input id="form_name" type="text" name="emailAddress" maxlength="50" size="30" class="form-control" placeholder="Email Address">
              </div>    <!--
              <div class="g-recaptcha" data-sitekey="6LfjePkSAAAAALAHmBmSN1B2EO_qtDAOskpliwTJ"></div> -->
              <input type="submit" class="btn btn-success btn-send subscribe-btn" value="Subscribe">
            </div>
          </form>
          <?php if ($subscribed == 'true'): ?>
            <div class="subscribedTrue subscribedMessage">
              Thanks. Now begin the eager anticipation of your first Anthea blog email.
            </div>
          <?php elseif ($subscribed == 'false') : ?>
            <div class="subscribedFalse subscribedMessage">
              That is not a valid email address, which will make it far trickier for me to send you blog updates. Try again.
            </div>
          <?php endif; ?>
        </div>
        <div class="divider"></div>
        <div class="links">
          <h3>Links I Like</h3>
          <ul class="linkslist">
            <li><a href="https://ohmygsoh.wordpress.com/" target="_blank">Oh My Gsoh</a> - Blog about the perils of dating mingled with literary delight</li>
            <li><a href="https://keevaoshea.blogspot.com/" target="_blank">Keeva O'Shea</a> - Witty observations about travel, life and accidental gin festivals</li>
            <li><a href="http://eileenkeane.ie/blog/" target="_blank">Eileen Keane</a> - Blog by author and artist Eileen Keane</li>
            <li><a href="http://francesquinn.blogspot.com/" target="_blank">Flying Away from Reality</a> - Blog by Frances Quinn</li>
          </ul>
        </div>
        <div class="divider"></div>
        <div class="twitterTimeline">
          <h3>Sometimes I Tweet</h3>
          <p>Mostly I retweet <a href="https://twitter.com/dog_feelings" target="_blank">@thoughtsofdog</a> though, so you could just follow them.</p>
          <a href="https://twitter.com/antheamiddleton?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">Follow @antheamiddleton</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
    </div>

    <!-- <div class="row commentSection">
      <div class="col-md-8">

      <a name="commentAnchor">
        <h2>Leave a Comment</h2>
      </a>
      <form name="contactform" method="post" action="../comment.php?postID=<?php echo $results['article']->id?>">
        <div class="messages"></div>
        <div class="controls">

          <div class="form-group">
            <label for="userName">Name</label>
            <input id="form_name" type="text" name="userName" maxlength="50" size="30" class="form-control" placeholder="Enter your name *" required="required" data-error="Firstname is required.">
            <div class="help-block with-errors"></div>
          </div>

          <div class="form-group">
            <label for="content">Comment</label>
            <textarea id="form_message" name="content" maxlength="1000" cols="25" rows="6" class="form-control" placeholder="Type message here *" rows="4" required="required" data-error="Please,leave us a message."></textarea>
            <div class="help-block with-errors"></div>
          </div>

          <div class="g-recaptcha" data-sitekey="6LfjePkSAAAAALAHmBmSN1B2EO_qtDAOskpliwTJ"></div>
        <input type="submit" class="btn btn-success btn-send comment-btn" value="Submit">
        </div>
      </form>


      <?php if ( $commentVal == 1 ): ?>
        <div class="commentThanks">
          Thank you for your comment. It is awaiting validation. Aren't we all.
        </div>
      <?php endif; ?>
    </div>
  </div>


  <?php if ( $commentCount > 0 ) { ?>
    <div class="row commentRow">
      <div class="col-md-8">
        <h2>Comments</h2>
        <?php foreach ( $results['comments'] as $comment ) { ?>
          <?php if ( $comment->published == 1): ?>
          <div class="commentDiv">
            <div class="commentTopRow">
              <h3>
                <?php echo $comment->userName ?>
              </h3>
              <div class="commentDate">
                <?php echo date('j F Y', $comment->publicationDate)?>
              </div>
            </div>
            <?php echo $comment->content?>
          </div>
          <?php endif; ?>
        <?php } ?>
      </div>
    </div>
  <?php } ?> -->
    </div>
    <div class="row">
      <div class="col-md-12">
        <p><a href="../">Return to Homepage</a></p>
      </div>
    </div>


  <div id="imagePopup" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <img class="modalImage" src="">
        </div>
      </div>

    </div>
  </div>
</section>


<?php include "include/footer.php" ?>
