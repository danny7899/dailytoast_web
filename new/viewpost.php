<?php
	
	include '../login/dbc.php'; 
	session_start();
	include_once("../analyticstracking.php");
	include '../includes/config.php';
	
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


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title> - Daily Toast</title>
    	<meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
        
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/templatemo_misc.css">
        <link rel="stylesheet" href="css/templatemo_style.css">

        <script src="js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->


        <div class="site-main" id="sTop">
            <div class="site-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <ul class="social-icons">
                                <li><a href="#" class="fa fa-facebook"></a></li>
                                <li><a href="#" class="fa fa-twitter"></a></li>
                                <li><a href="#" class="fa fa-dribbble"></a></li>
                                <li><a href="#" class="fa fa-linkedin"></a></li>
                            </ul>
                        </div> <!-- /.col-md-12 -->
                    </div> <!-- /.row -->
                </div> <!-- /.container -->
                <div class="main-header">
                    <div class="container">
                        <div id="menu-wrapper">
                            <div class="row">
                                <div class="logo-wrapper col-md-4 col-sm-2 col-xs-8">
                                    <h1>
                                        <a id="topTitle" href="#">Daily Toast</a>
                                    </h1>
                                </div> <!-- /.logo-wrapper -->
                                <div class="col-md-8 col-sm-10 col-xs-4 main-menu text-right">
                                    <ul class="menu-first hidden-sm hidden-xs">
                                        <li class="active"><a href="#">Home</a></li>
                                        <li><a href="#services">Services</a></li>
                                        <li><a href="#portfolio">Portfolio</a></li>
                                        <li><a href="#contact">Contact</a></li>
                                    </ul>
                                    <a href="#" class="toggle-menu visible-sm visible-xs"><i class="fa fa-bars"></i></a>
                                </div> <!-- /.main-menu -->
                            </div> <!-- /.row -->
                        </div> <!-- /#menu-wrapper -->
                        <div class="menu-responsive hidden-md hidden-lg">
                            <ul>
                                <li class="active"><a href="#">Home</a></li>
                                <li><a href="#services">Services</a></li>
                                <li><a href="#portfolio">Portfolio</a></li>
                                <li><a href="#contact">Contact</a></li>
                            </ul>
                        </div> <!-- /.menu-responsive -->
                    </div> <!-- /.container -->
                </div> <!-- /.main-header -->
            </div> <!-- /.site-header -->
            <div class="site-slider">
                <div class="slider">
                    <div class="flexslider">
                        <ul class="slides">
                            <li>
                                <div class="overlay"></div>
                                <img src="images/slide1.jpg" alt="">
                                <div class="slider-caption visible-md visible-lg">
                                    <h2>Digitalized News Feed</h2>
                                    <p>Let us serve you with inspiring news</p>
                                    <a href="#" class="slider-btn">Recent Toasts</a>
                                </div>
                            </li>
                            <li>
                                <div class="overlay"></div>
                                <img src="images/slide2.jpg" alt="">
                                <div class="slider-caption visible-md visible-lg">
                                    <h2>Real-Time</h2>
                                    <p>Live updates on worldwide news</p>
                                </div>
                            </li>
                            <li>
                                <div class="overlay"></div>
                                <img src="images/slide3.jpg" alt="">
                                <div class="slider-caption visible-md visible-lg">
                                    <h2>Professional Quality</h2>
                                    <p>New standard of online news feed</p>
                                </div>
                            </li>
                        </ul>
                    </div> <!-- /.flexslider -->
                </div> <!-- /.slider -->
            </div> <!-- /.site-slider -->
        </div> <!-- /.site-main -->


        <div class="content-section" id="services">
            <div class="container">
                <div class="row">
                    <div class="heading-section col-md-12 text-center">
                    </div> <!-- /.heading-section -->
                </div> <!-- /.row -->
                
                
                
                <div class="row" id="post_content">

                	<?php
    		            
                        $stmt3 = $db->prepare('SELECT full_name FROM users WHERE id =:userID');
                        $stmt3->execute(array(':userID' => $row['postAuthor']));
                        $authorName = $stmt3->fetch();
                        echo 'By '.$authorName['full_name'].', posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in ';

						$stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
						
						$stmt2->execute(array(':postID' => $row['postID']));
						
						$catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

						$links = array();
						foreach ($catRow as $cat) {
					    	$links[] = "<a href='../catpost.php?id=".$cat['catSlug']."'>".$cat['catTitle']."</a>";
						}
						
						echo implode(", ", $links);

				
				
				
				
						echo '<p id="view-count">';
						echo $row['postView'];
						if ($row['postView'] == 1) {
							echo ' view</p>';
						} else {
							echo ' views</p>';
							}
						echo '<br />';
						echo '<p>'.$row['postCont'].'</p>';
                	
					?>
	                                  
                    
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </div> <!-- /#services -->



        <div class="content-section" id="portfolio">
            <div class="container">
                <div class="row">
                    <div class="heading-section col-md-12 text-center">
                        <h2>Our Portfolio</h2>
                        <p>What we have done so far</p>
                    </div> <!-- /.heading-section -->
                </div> <!-- /.row -->
    
                <div class="row">
                    <div class="portfolio-item col-md-3 col-sm-6">
                        <div class="portfolio-thumb">
                            <img src="images/gallery/p1.jpg" alt="">
                            <div class="portfolio-overlay">
                                <h3>New Street</h3>
                                <p>Asperiores commodi illo fuga perferendis dolore repellendus sapiente ipsum.</p>
                                <a href="images/gallery/p1.jpg" data-rel="lightbox" class="expand">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div> <!-- /.portfolio-overlay -->
                        </div> <!-- /.portfolio-thumb -->
                    </div> <!-- /.portfolio-item -->
                    
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </div> <!-- /#portfolio -->

        <div class="content-section" id="contact">
            <div class="container">
                <div class="row">
                    <div class="heading-section col-md-12 text-center">
                        <h2>Contact Us</h2>
                        <p>Feel free to send a message</p>
                    </div> <!-- /.heading-section -->
                </div> <!-- /.row -->
                <div class="row">
                    <div class="col-md-7 col-sm-6">
                        <p>Duis ullamcorper tortor tellus. Ut diam libero, ultricies non augue a, mollis congue risus. Fusce a quam eget nisi luctus imperdiet. Aenean semper erat neque. Nunc et scelerisque nunc, in adipiscing magna. Phasellus in erat non tellus molestie sagittis sed a justo. Nam vehicula volutpat nibh, in posuere dolor dictum sit amet.<br><br>
				    Consectetur quod at aperiam corporis totam. Nesciunt minima laborum sapiente totam facere unde est cum quia. Hic, suscipit, praesentium earum quod ea distinctio impedit ullam deserunt minus dolore quibusdam quis saepe aliquam doloribus voluptatibus eum excepturi.
                    	</p>
                        <ul class="contact-info">
                            <li>Phone: 010-080-0180</li>
                            <li>Email: <a href="mailto:info@company.com">info@company.com</a></li>
                            <li>Address: 123 Premium Studio, Thamine Street, Digital Estate</li>
                        </ul>
                        <!-- spacing for mobile viewing --><br><br>
                    </div> <!-- /.col-md-7 -->
                    <div class="col-md-5 col-sm-6">
                        <div class="contact-form">
                            <form method="post" name="contactform" id="contactform">
                                <p>
                                    <input name="name" type="text" id="name" placeholder="Your Name">
                                </p>
                                <p>
                                    <input name="email" type="text" id="email" placeholder="Your Email"> 
                                </p>
                                <p>
                                    <input name="subject" type="text" id="subject" placeholder="Subject"> 
                                </p>
                                <p>
                                    <textarea name="comments" id="comments" placeholder="Message"></textarea>    
                                </p>
                                <input type="submit" class="mainBtn" id="submit" value="Send Message">
                            </form>
                        </div> <!-- /.contact-form -->
                    </div> <!-- /.col-md-5 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </div> <!-- /#contact -->
            
        <div id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-xs-12 text-left">
                        Copyright © 2015 Daily Toast
                    </div> <!-- /.text-center -->
                    <div class="col-md-4 hidden-xs text-right">
                        <a href="#top" id="go-top">Back to top</a>
                    </div> <!-- /.text-center -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </div> <!-- /#footer -->
        
        <script src="js/vendor/jquery-1.11.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
        <script src="js/bootstrap.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>


        <!-- Google Map -->
        <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script src="js/vendor/jquery.gmap3.min.js"></script>
        
        <!-- Google Map Init-->
        <script type="text/javascript">
            jQuery(function($){
                $('#map_canvas').gmap3({
                    marker:{
                        address: '16.8496189,96.1288854' 
                    },
                        map:{
                        options:{
                        zoom: 15,
                        scrollwheel: false,
                        streetViewControl : true
                        }
                    }
                });
            });
        </script>
    </body>
</html>