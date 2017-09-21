
<?php
//database credentials
define ("DB_HOST", "fdb7.awardspace.net"); // set database host
define ("DB_USER", "1874117_danny"); // set database user
define ("DB_PASS","Dan781999"); // set database password
define ("DB_NAME","1874117_danny"); // set database name

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Couldn't make connection.");
//$db = mysqli_select_db($link, DB_NAME) or die("Couldn't select database");
$response = array();


if($_GET['submit'] == "Submit" && $_GET['title'] != "" && $_GET['catID'] != "" && $_GET['desc'] != "" && $_GET['cont'] != "" && $_GET['author'] != ""){

	
	// receiving the post params
    $postTitle = $_GET['title'];
    $postCategory = $_GET["catID"];
    $postDesc = $_GET['desc'];
    $postCont = $_GET['cont'];
    $postAuthor = $_GET['author'];
    $postSlug = slug($postTitle);
    $postDate = date('Y-m-d H:i:s');
		
		//insert into database
		$stmt = mysqli_query($link, "INSERT INTO blog_posts_seo (postTitle,postAuthor,postSlug,postDesc,postCont,postDate) VALUES ('".$postTitle."', '".$postAuthor."', '".$postSlug."', '".$postDesc."', '".$postCont."', '".$postDate."')");
		$postID = mysqli_insert_id($link);
		
		//add categories
		mysqli_query($link, "INSERT INTO blog_post_cats (postID,catID) VALUES ('".$postID."', '".$postCategory."')");
	
		$response["error"] = FALSE;
        echo json_encode($response);


} else {
	echo $_GET["submit"];
	$response["error"] = TRUE;
	$response["error_msg"] = "Data required missing.";
	echo json_encode($response);
	
}

function slug($text){ 

  // replace non letter or digits by -
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

  // trim
  $text = trim($text, '-');

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // lowercase
  $text = strtolower($text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  if (empty($text))
  {
    return 'n-a';
  }

  return $text;
}



mysqli_close($link);
?>