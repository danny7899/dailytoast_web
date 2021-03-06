<?php include '../includes/config.php'; ?><html lang="en">
  <head>
    <link rel="shortcut icon" href="../images/icon.ico">
    <meta charset="UTF-8">
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="../apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="../apple-touch-icon-120x120.png" />
<link rel="icon" type="image/png" href="../favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="../favicon-16x16.png" sizes="16x16" />
<meta name="application-name" content="&nbsp;"/>
<meta name="msapplication-TileColor" content="#FFFFFF" />
<meta name="msapplication-TileImage" content="../mstile-144x144.png" />

    <title><?php echo $page_title; ?></title>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" type="text/css" media="screen" href="../stylesheets/style.css" />
    <link rel="stylesheet" type="text/css" media="only screen and (max-width: 1023px)" href="../stylesheets/style-mobile.css"/>
    <meta content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
    <script>
      $(document).ready(function(){
        $("#logForm").validate();
      });
    </script>
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
    
    <!--[if lt IE 9]>
      <script>
        document.createElement("article");
        document.createElement("aside");
        document.createElement("footer");
        document.createElement("header");
        document.createElement("main");
        document.createElement("nav");
        document.createElement("section");
      </script>
    <![endif]-->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  </head>

  <body>
    <?php include_once("../analyticstracking.php") ?>
  <div id="header">
    
    <header class="banner">
      
      <div class="ribbon">
        <i><span><s></s><img src="../images/logo.png" align="left" width="64" height="64"><s></s></span></i>
      </div>

      
        <?php if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_name']) ){
          echo "<div id=\"login\"><a href=\"login.php\">".'Sign In'."</a></div>";
        }else{
          echo "<div id=\"login\">".'Hi, '."<a href=\"myaccount.php\">".$_SESSION['user_name']."</a>".'! '."<a href=\"logout.php\">".'Logout'."</div></a>";}
        ?>
      
	      <div id="logo"><img src="../images/logo.png" align="left" width="56" height="56"></div>
        <div id="title">
		      <h1>Daily Toast</h1>
          <p>Worldwide News in Real - Time</p>
        </div>
      </header>
  
      <nav>
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="../archive.php">Archives</a></li>
          <li><a href="../about.php">About</a></li>
        </ul>
      </nav>
  	</div>