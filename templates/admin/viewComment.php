<?php include "/home3/a559959/antheatest.com/templates/include/header.php" ?>
<section>
    <div class="container">
      <div class="row adminHeaderRow">
        <div class="col-md-12">
          <div id="adminHeader">
            <h2>Admin Panel</h2>
            <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="admin.php?action=logout"?>Log out</a></p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h1>Comment</h1>

          <?php if ( isset( $results['errorMessage'] ) ) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
          <?php } ?>


          <?php if ( isset( $results['statusMessage'] ) ) { ?>
            <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
          <?php } ?>

          <div class="tableDiv">
            <table>
              <tr>
                <th>Publication Date</th>
                <th>Article</th>
              </tr>

      <?php foreach ( $results['articles'] as $article ) { ?>
              <tr onclick="location='admin.php?action=editArticle&amp;articleId=<?php echo $article->id?>'">
                <td><?php echo date('j M Y', $article->publicationDate)?></td>
                <td>
                  <?php echo $article->title?>
                </td>
              </tr>

      <?php } ?>

            </table>
          </div>
        </div>

        <div class="col-md-6">
          <h2>Comments</h2>
        </div>
      </div>



      <p><?php echo $results['totalRows']?> article<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>

      <p><a href="admin.php?action=newArticle">Add a New Article</a></p>
    </div>
  </section>

<?php include "/home3/a559959/antheatest.com/templates/include/footer.php" ?>
