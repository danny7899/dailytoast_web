<?php
  $page_title = "Home - Daily Toast";
  include 'frag/header.php'; 
  //include 'blog/includes/config.php';     
?>

     	<div id="content">
            <main>
                <section>
                    <h2>Recent Toasts</h2>
                    <div id="blog">
                        <?php
                        include 'includes/config.php';
                            try {

                                //instantiate the class
                                $pages = new Paginator('4','p');

                                //collect all records from the next function
                                $stmt = $db->query('SELECT postID FROM blog_posts_seo');

                                //determine the total number of records
                                $pages->set_total($stmt->rowCount());

                                $stmt = $db->query('SELECT postID, postTitle, postAuthor, postSlug, postDesc, postDate, postView FROM blog_posts_seo ORDER BY postID DESC '.$pages->get_limit());
                                while($row = $stmt->fetch()){
                    
                                    echo '<article>';
                                    echo '<header>';
                                    echo '<h3><a href="viewpost.php?id='.$row['postSlug'].'">'.$row['postTitle'].'</a></h3>';
                                    echo '<p>'; 

                                    $stmt3 = $db->prepare('SELECT full_name FROM users WHERE id =:userID');
                                    $stmt3->execute(array(':userID' => $row['postAuthor']));
                                    $authorName = $stmt3->fetch();
                                    echo 'By '.$authorName['full_name'].', posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in ';

                                    $stmt2 = $db->prepare('SELECT catTitle, catSlug FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
                                    $stmt2->execute(array(':postID' => $row['postID']));

                                    $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                    $links = array();
                                    foreach ($catRow as $cat) {
                                        $links[] = "<a href='catpost.php?id=".$cat['catSlug']."'>".$cat['catTitle']."</a>";
                                    }
                                    echo implode(", ", $links);

                                    echo '</p>';
                                    
                                    //Begin collecting stats
                                    $cmtx_path = 'comments/';
                                    require_once 'comments/extractor.php';
                                    $extractor = new extractor($cmtx_path);
                                    
									echo '<ul class="post-stats">';
									echo '<li id="view-count">';
                                    echo $row['postView'];
                                    if ($row['postView'] == 1) {
	                                    echo ' view</li>';
                                    } else {
	                                    echo ' views</li>';
                                    }
                                    echo '<li id="comment-count">';
                                    $comment_count = $extractor->commentCount($row['postID']);
                                    echo $comment_count;
                                    echo '<li id="post-rating">Rating: ';
                                    echo $extractor->pageRating($row['postID']);
                                    echo '</li>';
                                    echo '</ul>';
                                    //End collecting stats
                                    
                                    
                                    echo '</header>';
                                    echo '<br />';

                                    echo '<p>'.$row['postDesc'].'</p>';                                         
                                    
                                    echo '<p id="extras"><a href="viewpost.php?='.$row['postSlug'].'">Read More</a></p>';
                                    echo '</article>';
                                }

                                echo $pages->page_links();

                            }

                            catch(PDOException $e) {
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