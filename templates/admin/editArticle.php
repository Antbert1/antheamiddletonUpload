<?php include "/home3/a559959/antheatest.com/templates/include/header.php" ?>

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <div id="adminHeader">
        <h2>Admin Panel - Edit Article</h2>
        <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="admin.php?action=logout"?>Log out</a></p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <h1><?php echo $results['pageTitle']?></h1>

      <form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
        <input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>"/>

        <?php if ( isset( $results['errorMessage'] ) ) { ?>
          <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
        <?php } ?>

        <ul class="inputFields">

          <li>
            <label for="title">Article Title</label><br>
            <input class="inputField" type="text" name="title" id="title" placeholder="Name of the article" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']->title )?>" />
          </li>

          <li>
            <label for="categories">Categories</label><br>
            <input class="inputField" type="text" name="categories" id="categories" placeholder="Categories, comma separated" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']->categories )?>" />
          </li>

          <li>
            <label for="tags">Tags</label><br>
            <input class="inputField" type="text" name="tags" id="tags" placeholder="Tags, comma separated" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']->tags )?>" />
          </li>

          <li>
            <label for="summary">Article Summary</label><br>
            <textarea class="inputField" name="summary" id="summary" placeholder="Brief description of the article" required maxlength="1000" style="height: 5em;"><?php echo htmlspecialchars( $results['article']->summary )?></textarea>
          </li>

          <li>
            <label for="content">Article Content</label><br>
            <textarea class="inputField" name="content" id="content" placeholder="The HTML content of the article" required maxlength="100000" style="height: 30em;"><?php echo htmlspecialchars( $results['article']->content )?></textarea>
          </li>

          <li>
            <label for="image">Image</label><br>
            <input class="inputField" type="text" name="image" id="image" placeholder="Name of the image" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']->image )?>" />
          </li>

          <li>
            <label for="publicationDate">Publication Date</label><br>
            <input class="inputField" type="date" name="publicationDate" id="publicationDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo $results['article']->publicationDate ? date( "Y-m-d", $results['article']->publicationDate ) : "" ?>" />
          </li>


        </ul>

        <div class="buttons">
          <input class="btn btn-primary btn-save" type="submit" name="saveChanges" value="Save Changes" />
          <input type="submit" class= "btn btn-primary btn-cancel" formnovalidate name="cancel" value="Cancel" />
        </div>

      </form>

<?php if ( $results['article']->id ) { ?>
      <p><a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']->id ?>" onclick="return confirm('Delete This Article?')">Delete This Article</a></p>
<?php } ?>

    </div>
  </div>
</div>

<?php include "/home3/a559959/antheatest.com/templates/include/footer.php" ?>
