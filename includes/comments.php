<?php
include("helper.php");

$results = mysql_query("SELECT * FROM comment WHERE postID = ".$postID."");
$items = array();
while ($row = mysql_fetch_assoc($results)) {
    $items[] = $row;
}
$comments = format_comments($items);


 
/*
 * End of comments.php
 */
 
 ?>