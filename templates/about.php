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
?>

<section>
  <div class="container">
    <div class="row">
      <div class="col-md-4 aboutBlurb">
        <p>My name is Anthea Middleton, which is a bit of a weird name, and people often don't believe me. When I was in 6th year in school someone told me it was like a hobbit name though, and that made me happy.</p>
        <p>I currently work as a software developer in Scotland, in spooky re-purposed art deco high school.</p>
        <p>I make electronic things for fun, and if I ever finish any of them and stop adding new features I'll write about it here. I also enjoy aerial acrobatic dance and read lots of sci-fi and detective novels. I'm trying to write my own novel at the moment. It's like this blog but fictional and set partly in space.</p>
        <p>That's me there. With a Paddington.</p>
      </div>
      <div class="col-md-4">
        <img src="images/about/anthea.jpg" class="aboutImage" />
      </div>
      <div class="col-md-4 RHSSection">
        <div class="subscribe">
          <h3>Subscribe</h3>
          Subscribe to my blog for email updates on new posts.
            <form name="subscribeform" method="post" action="subscribe.php">
            <div class="controls">

              <div class="form-group">
                <input id="form_name" type="text" name="emailAddress" maxlength="50" size="30" class="form-control" placeholder="Email Address">
              </div>
    <!--
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
        <div class="extraSpace"></div>
    </div>
    </div>
  </div>
</section>

<?php include "include/footer.php" ?>
