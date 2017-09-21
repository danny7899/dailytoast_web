<?php
	include '../login/dbc.php';
	session_start();
	page_protect();
	ob_start();
?>
<head>
	<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
    <script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
    </script>
</head>

<?php   	$page_title = "Post a Toast - Daily Toast";
  	include '../frag/headerlog.php'; ?>



     	<div id="content">
            <main>
                <section>
                    <h2>My Account - Post a Toast</h2>
                    <div id="blog">
                    	<article>                       
                       <?php
                      //require('../includes/config.php');

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		//collect form data
		extract($_POST);

		//very basic validation
		if($postTitle ==''){
			$error[] = 'Please enter the title.';
		}

		if($postDesc ==''){
			$error[] = 'Please enter the description.';
		}

		if($postCont ==''){
			$error[] = 'Please enter the content.';
		}

		if(!isset($error)){

			try {

				$postSlug = slug($postTitle);

				//insert into database
				$stmt = $db->prepare('INSERT INTO blog_posts_seo (postTitle,postAuthor,postSlug,postDesc,postCont,postDate) VALUES (:postTitle, :postAuthor, :postSlug, :postDesc, :postCont, :postDate)') ;
				$stmt->execute(array(
					':postTitle' => $postTitle,
					':postAuthor' => $_SESSION['user_id'],
					':postSlug' => $postSlug,
					':postDesc' => $postDesc,
					':postCont' => $postCont,
					':postDate' => date('Y-m-d H:i:s')
				));
				$postID = $db->lastInsertId();

				//add categories
				if(is_array($catID)){
					foreach($_POST['catID'] as $catID){
						$stmt = $db->prepare('INSERT INTO blog_post_cats (postID,catID)VALUES(:postID,:catID)');
						$stmt->execute(array(
							':postID' => $postID,
							':catID' => $catID
						));
					}
				}

				//redirect to index page
				header("Location: http://dailytoast.dx.am/index.php");
				die();

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form id="poster" action='' method='post'>

		<p><label>Title</label><br />
		<input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>' ></p>

		<p><label>Description</label><br />
		<textarea name='postDesc' cols='60' rows='5'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

		<p><label>Content</label><br />
		<textarea name='postCont' cols='60' rows='15'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>

		</ br>
		<fieldset>
			<legend>Categories</legend>

			<?php	

			$stmt2 = $db->query('SELECT catID, catTitle FROM blog_cats ORDER BY catTitle');
			while($row2 = $stmt2->fetch()){

				if(isset($_POST['catID'])){

					if(in_array($row2['catID'], $_POST['catID'])){
                       $checked="checked='checked'";
                    }else{
                       $checked = null;
                    }
				}

			    echo "<input type='checkbox' name='catID[]' value='".$row2['catID']."' $checked> ".$row2['catTitle']."<br />";
			}

			?>

		</fieldset>

		<p><input type='submit' name='submit' value='Submit'></p>

	</form>
						</article>
                    </div>

                </section>
            </main>
            <?php include('../frag/sidebarlog.php'); ?>    
	    </div>
	
	    <div id="footer">
            <?php include('../frag/footer.php'); ?>
	    </div>

    </body>
</html>