<?php
  $page_title = "Home - Daily Toast";
  include '../frag/headerlog.php'; 
  //include 'blog/includes/config.php';     
?>
	<head>
        <meta charset="UTF-8">
        <title>Nested or hierarchical comment system in PHP, AJAX, Jquery</title>
        <link rel="stylesheet" href="../stylesheets/comments.css">
        <script src="comments/js/jquery-1.9.1.min.js"></script>
        <script src="comments/js/jquery-ui-1.10.3-custom.min.js"></script>
        <script src="comments/js/jquery-migrate-1.2.1.js"></script>
        <script src="comments/js/jquery.blockUI.js"></script>
        <script src="comments_blog.js"></script>
    </head>



<?php 	
	
	include("comments.php");  
	
?>



     	<div id="content">
            <main>
                <section>
                    <h2>Recent Toasts</h2>
                    <div style="width: 600px;">
            <div id="comment_wrapper">
                <div id="comment_form_wrapper">
                    <div id="comment_resp"></div>
                    <h4>Please Leave a Reply<a href="javascript:void(0);" id="cancel-comment-reply-link">Cancel Reply</a></h4>
                    <form id="comment_form" name="comment_form" action="" method="post">
                        <div>
                            Name<input type="text" name="comment_name" id="comment_name" size="54"/>
                        </div>
                        <div>
                            Email<input type="text" name="comment_email" id="comment_email" size="54"/>
                        </div>
                        <div>
                            Website<input type="text" name="comment_web" id="comment_web" size="54"/>
                        </div>
                        <div>
                            Comment<textarea name="comment_text" id="comment_text" rows="6"></textarea>
                        </div>
                        <div>
                            <input type="hidden" name="reply_id" id="reply_id" value=""/>
                            <input type="hidden" name="depth_level" id="depth_level" value=""/>
                            <input type="submit" name="comment_submit" id="comment_submit" value="Post Comment" class="button"/>
                        </div>
                    </form>
                </div>
                <?php
                echo $comments;
                ?>
            </div>
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