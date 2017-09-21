<?php
  $page_title = "Home - Daily Toast";
  include 'frag/header.php'; 
  //include 'blog/includes/config.php';     
?>

     	<div id="content">
            <main>
                <section>
                	<?php
                		$monthName = date("F", mktime(0, 0, 0, $_GET['month'], 10));
                	?>

                    <h2 id="headline">Archives - <?php echo $monthName.' '.$_GET["year"]; ?></h2>
                    <div id="blog">
                        <?php
                        include 'includes/config.php';
			try {

				//collect month and year data
$month = $_GET['month'];
$year = $_GET['year'];

//set from and to dates
$from = date('Y-m-01 00:00:00', strtotime("$year-$month"));
$to = date('Y-m-31 23:59:59', strtotime("$year-$month"));

$stmt = $db->prepare('SELECT postID, postTitle, postAuthor, postSlug, postDesc, postDate, postView FROM blog_posts_seo WHERE postDate >= :from AND postDate <= :to ORDER BY postID DESC');
$stmt->execute(array(
    ':from' => $from,
    ':to' => $to
));
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
							    $links[] = "<a href='c-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
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








<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

	<div id="wrapper">


		<h1>Blog</h1>
		<hr />
		<div id='main'>

    <!-- php code here -->
<?php
			try {

				//collect month and year data
$month = $_GET['month'];
$year = $_GET['year'];

//set from and to dates
$from = date('Y-m-01 00:00:00', strtotime("$year-$month"));
$to = date('Y-m-31 23:59:59', strtotime("$year-$month"));

$stmt = $db->prepare('SELECT postID, postTitle, postSlug, postDesc, postDate FROM blog_posts_seo WHERE postDate >= :from AND postDate <= :to ORDER BY postID DESC');
$stmt->execute(array(
    ':from' => $from,
    ':to' => $to
));
				while($row = $stmt->fetch()){
					
					echo '<div>';
						echo '<h1><a href="viewpost.php?id='.$row['postSlug'].'">'.$row['postTitle'].'</a></h1>';
						echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in ';

							$stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
							$stmt2->execute(array(':postID' => $row['postID']));

							$catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

							$links = array();
							foreach ($catRow as $cat)
							{
							    $links[] = "<a href='c-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
							}
							echo implode(", ", $links);

						echo '</p>';
						echo '<p>'.$row['postDesc'].'</p>';				
						echo '<p><a href="'.$row['postSlug'].'">Read More</a></p>';				
					echo '</div>';

				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>
</div>

<div id='sidebar'>
    <?php require('sidebar.php'); ?>
</div>

		

	</div>


</body>
</html>