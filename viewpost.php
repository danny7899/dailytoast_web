<?php
  $page_title = "View Toast - Daily Toast";
  include 'frag/header.php'; 
  require('includes/config.php'); 



$stmt = $db->prepare('SELECT postID FROM blog_posts_seo WHERE postSlug = :postSlug');
$stmt->execute(array(':postSlug' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['postID'] == ""){
	header('Location:404.php');
	exit;
}

$view_sql="UPDATE blog_posts_seo SET postView=postView+1 WHERE postID = ".$row['postID'];
				mysql_query($view_sql);
				
				$stmt = $db->prepare('SELECT postID, postTitle, postAuthor, postCont, postDate, postView FROM blog_posts_seo WHERE postSlug = :postSlug');
				$stmt->execute(array(':postSlug' => $_GET['id']));
				$row = $stmt->fetch();




?>

     	<div id="content">
            <main>
                <section>
                    <h2>View Toast</h2>
                    <div id="blog">
                        <?php
                        	
			echo '<article>';
			echo '<header>';
				echo '<h3>'.$row['postTitle'].'</h3>';
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
				echo '<p>'.$row['postCont'].'</p>';	
							
				echo '</article>';
			?>
		
			<article>
				<?php
					$cmtx_set_name_value = $_SESSION['user_name'];
					$cmtx_set_email_value = $_SESSION['user_email'];
					$cmtx_set_website_value = $_SESSION['user_website'];
					$cmtx_set_country_value = $_SESSION['user_country'];
					
					$cmtx_identifier = $row['postID'];
					$cmtx_reference = $row['postTitle'];
					$cmtx_path = 'comments/';
					require $cmtx_path . 'includes/commentics.php'; //don't edit this line
				?>
			</article>
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