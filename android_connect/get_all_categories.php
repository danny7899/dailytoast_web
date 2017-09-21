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
$result = mysql_query("SELECT catID, catTitle FROM blog_cats ORDER BY catID ASC") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["categories"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $product = array();
        
        
		$result2 = mysql_query('SELECT COUNT(postID) FROM blog_post_cats WHERE catID = '.$row["catID"]);
		$row2 = mysql_fetch_array($result2);
        
        $product["id"] = $row["catID"];
        $product["name"] = $row["catTitle"];
        $product["count"] = $row2["COUNT(postID)"];
        



        // push single product into final response array
        array_push($response["categories"], $product);
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
