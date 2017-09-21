<?php
  $page_title = $_POST['search']." - Daily Toast";
  include 'frag/header.php'; 
  require('includes/config.php'); 

if($_POST['search'] == "") {
	header("Location:index.php");
}
 $search_sql="SELECT * FROM blog_posts_seo WHERE postTitle LIKE '%".$_POST['search']."%' OR postDesc LIKE '%".$_POST['search']."%' OR postCont LIKE '%".$_POST['search']."%'";

$search_query=mysql_query($search_sql);
 if (mysql_num_rows($search_query) != 0) {
	 $search_rs=mysql_fetch_assoc($search_query);
 }

?>
     	<div id="content">
            <main>
                <section>
                    <h2>Search Results - <?php echo $_POST["search"]?></h2>
                    <div id="blog">
                        <?php
			try {
if(mysql_num_rows($search_query) != 0) {
				do{
					$data_sql="SELECT postID, postSlug, postTitle, postAuthor, postDesc, postCont, postDate, postView FROM blog_posts_seo WHERE postID =".$search_rs['postID'];
					$data_query=mysql_query($data_sql);
					$data_rs=mysql_fetch_assoc($data_query);
					
					
				/*
					$stmt = $db->prepare("SELECT postID, postSlug, postTitle, postAuthor, postDesc,postCont, postDate FROM blog_posts_seo WHERE postID = :result");
					$stmt->execute(array(':result' => $search_rs['postSlug']));
				
				*/
				
					echo '<article>';
					echo '<header>';
						echo '<h2><a href="viewpost.php?id='.$data_rs['postSlug'].'">'.$data_rs['postTitle'].'</a></h2>';
						echo '<p>'; 

                                    $stmt3 = $db->prepare('SELECT full_name FROM users WHERE id =:userID');
                                    $stmt3->execute(array(':userID' => $data_rs['postAuthor']));
                                    $authorName = $stmt3->fetch();
                                    echo 'By '.$authorName['full_name'].', posted on '.date('jS M Y H:i:s', strtotime($data_rs['postDate'])).' in ';

							$stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
							$stmt2->execute(array(':postID' => $data_rs['postID']));

							$catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

							$links = array();
							foreach ($catRow as $cat)
							{
							    $links[] = "<a href='c-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
							}
							echo implode(", ", $links);

						echo '</p>';

                                    echo '<p id="view-count">';
                                    echo $data_rs['postView'];
                                    if ($data_rs['postView'] == 1) {
	                                    echo ' view</p>';
                                    } else {
	                                    echo ' views</p>';
                                    }
                                    						
						echo '</header>';
						echo '<br />';

						echo '<p>'.$data_rs['postDesc'].'</p>';				
						echo '<p id="extras"><a href="viewpost.php?id='.$data_rs['postSlug'].'">Read More</a></p>';
						echo '</article>';
					} while($search_rs=mysql_fetch_assoc($search_query));
				} else {
					echo "<article><header>No matches found</header></article>";
				}
					

			} catch(PDOException $e) {echo $e->getMessage();}
		?>


                    </div>
                </section>
            </main>
            <?php include('frag/sidebar.php'); ?>    
	    </div>
	
	    <div id="footer">
            <?php include('frag/footer.php'); ?>
	    </div>

    </body>
</html>