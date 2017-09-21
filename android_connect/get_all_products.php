<?php

/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();


// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// get all products from products table
$result = mysql_query("SELECT * FROM blog_posts_seo ORDER BY postID DESC") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["products"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $product = array();
        
        $name = strip_tags($row["postTitle"]);
        $description = strip_tags($row["postDesc"]);
        
        $stmt2 = mysql_query("SELECT full_name FROM users WHERE id = ".$row['postAuthor']);
        $authorName = mysql_fetch_array($stmt2);
        
        $stmt3 = mysql_query('SELECT catTitle FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = '.$row["postID"]);
        $catRow = array(); 
        $category = array();
        //$catRow = mysql_fetch_array($stmt3);      
        while($catRow =  mysql_fetch_assoc($stmt3)) {
			$category[] = $catRow['catTitle'];
		}
		
        $cmtx_path = '../comments/';
        require_once '../comments/extractor.php';
        $extractor = new extractor($cmtx_path);
        $comment_count = strip_tags($extractor->commentCountInt($row['postID']));
        
        
        
        $product["id"] = $row['postID'];
        $product["name"] = $name;
        $product["description"] = $description;
        $product["created_at"] = date('jS M Y', strtotime($row['postDate']));
        $product["created_by"] = strip_tags($authorName['full_name']);
        $product["views"] = $row["postView"];
        $product["category"] = implode(", ", $category);
        $product["comment"] = $comment_count;
        



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
?>
