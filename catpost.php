<?php
  $page_title = "Categories - Daily Toast";
  include 'frag/header.php'; 
  include 'includes/config.php';
  //include 'blog/includes/config.php'; 
  $stmt = $db->prepare('SELECT catID,catTitle FROM blog_cats WHERE catSlug = :catSlug');
$stmt->execute(array(':catSlug' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['catID'] == ''){
	header('Location: ./');
	exit;
}    
?>

     	<div id="content">
            <main>
                <section>
                    <h2 id="headline">Category - <?php echo $_GET["id"]; ?></h2>
                    <div id="blog">
                        
						<?php	
						
		try {


			$stmt = $db->prepare('
				SELECT 
					blog_posts_seo.postID, blog_posts_seo.postTitle, blog_posts_seo.postAuthor, blog_posts_seo.postSlug, blog_posts_seo.postDesc, blog_posts_seo.postDate, blog_posts_seo.postView 
				FROM 
					blog_posts_seo,
					blog_post_cats
				WHERE
					 blog_posts_seo.postID = blog_post_cats.postID
					 AND blog_post_cats.catID = :catID
				ORDER BY 
					postID DESC
				');
			$stmt->execute(array(':catID' => $row['catID']));
			while($row = $stmt->fetch()){
				
				echo '<article>';
				echo '<header>';
					echo '<h2><a href="viewpost.php?id='.$row['postSlug'].'">'.$row['postTitle'].'</a></h2>';
					echo '<p>'; 

                                    $stmt3 = $db->prepare('SELECT full_name FROM users WHERE id =:userID');
                                    $stmt3->execute(array(':userID' => $row['postAuthor']));
                                    $authorName = $stmt3->fetch();
                                    echo 'By '.$authorName['full_name'].', posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in ';

						$stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
						$stmt2->execute(array(':postID' => $row['postID']));

						$catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

						$links = array();
						foreach ($catRow as $cat)
						{
						    $links[] = "<a href='catpost.php?id=".$cat['catSlug']."'>".$cat['catTitle']."</a>";
						}
						echo implode(", ", $links);

					echo '</p>';				
                echo '<p id="view-count">';
                echo $row['postView'];
                if ($row['postView'] == 1) {
	            	echo ' view</p>';
                } else {
	                echo ' views</p>';
                }


					echo '</header>';
					echo '<br />';
					echo '<p>'.$row['postDesc'].'</p>';				
					echo '<p><a href="'.$row['postSlug'].'">Read More</a></p>';				
				echo '</article>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

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