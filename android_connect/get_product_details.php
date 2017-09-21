<?php

/*
 * Following code will get single product details
 * A product is identified by product id (pid)
 */

// array for JSON response
$response = array();


// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// check for post data
if (isset($_GET["pid"])) {
    $pid = $_GET['pid'];
    
    $view_sql="UPDATE blog_posts_seo SET postView=postView+1 WHERE postID = ".$pid;
	mysql_query($view_sql);

	// get all products from products table
	$result = mysql_query("SELECT * FROM blog_posts_seo WHERE postID = ".$pid) or die(mysql_error());

	// check for empty result
	if (mysql_num_rows($result) > 0) {
	    // looping through all results
		// products node
		$response["products"] = array();
    
		while ($row = mysql_fetch_array($result)) {
        	// temp user array
			$product = array();
			
			$content = strip_tags($row['postCont']);
        
			$product["content"] = $content;

			// push single product into final response array
			array_push($response["products"], $product);
		}
		// success
		$response["success"] = 1;
		
		// echoing JSON response
		echo json_encode($response);
	} else {
    	// no products found
		$response["success"] = 0;
		$response["message"] = "No products found";

		// echo no users JSON
		echo json_encode($response);
	}

} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>