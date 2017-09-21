<?php
    include 'dbc.php'; 
  session_start();

  $page_title = "My Account - Daily Toast";
  include '../frag/headerlog.php'; 
  page_protect();  
  //require  '../includes/config.php';
?>

  <div id="content">
    <main>
      <section>
        <?php 
      if (isset($_GET['msg'])) {
    echo "<div class=\"error\">$_GET[msg]</div>";
    }
        
    ?>
        <h2>My Account</h2>
        <article>
          <header>
          <h3>Welcome <?php echo $_SESSION['user_name'];?></h3>

           <br/>
          </header>
          
            <p><a href="../admin/add-post.php">Post a Toast</a></p>
            <p><a href="mysettings.php">Account Settings</a></p>
            
            <?php 
              if (checkAdmin()) {
              ?>
              <p><a href="../admin/admin.php">Admin CP </a></p>
              <p><script type="text/javascript" src="http://feedjit.com/serve/?vv=1515&amp;tft=3&amp;dd=0&amp;wid=&amp;pid=0&amp;proid=0&amp;bc=DCE0C5&amp;tc=303030&amp;brd1=CED6A3&amp;lnk=8A8A03&amp;hc=BABD93&amp;hfc=706B38&amp;btn=4F4F4F&amp;ww=221&amp;wne=10&amp;srefs=1"></script><noscript><a href="http://feedjit.com/">Live Traffic Stats</a></noscript></p>
              <?php } ?>
              <p>Place any text here. This is the my account page</p>
              <p>This is the my account page</p>
        </article>
      </section>
    </main>

    <?php include('../frag/sidebarlog.php'); ?>
  </div>
  
  <div id="footer">
    <?php include('../frag/footer.php'); ?>
  </div>
  </div>
  </body>
</html>