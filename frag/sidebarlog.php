<aside>
<h2>Search Toasts</h2>
<hr />
<form name="search-form" method="post" action="../results.php">
	<input name="search" type="text" size="20" maxlength="50"/>	
	<input type="submit" name="Submit"  value="Search"/> 
</form> 

	<h2>Recent Posts</h2>
<hr />

<ul>
<?php
$stmt = $db->query('SELECT postTitle, postSlug FROM blog_posts_seo ORDER BY postID DESC LIMIT 5');
while($row = $stmt->fetch()){
    echo '<li><a href="../viewpost.php?id='.$row['postSlug'].'">'.$row['postTitle'].'</a></li>';
}
?>
</ul>

<br />


<h2>Categories</h2>
<hr />

<ul>
<?php
$stmt = $db->query('SELECT catTitle, catSlug FROM blog_cats ORDER BY catID DESC');
while($row = $stmt->fetch()){
    echo '<li><a href="../catpost.php?id='.$row['catSlug'].'">'.$row['catTitle'].'</a></li>';
}
?>
</ul>

<br />


<h2>Archives</h2>
<hr />
<ul>
<?php
$stmt = $db->query("SELECT Month(postDate) as Month, Year(postDate) as Year FROM blog_posts_seo GROUP BY Month(postDate), Year(postDate) ORDER BY postDate DESC");
while($row = $stmt->fetch()){
    $monthName = date("F", mktime(0, 0, 0, $row['Month'], 10));
    echo '<li><a href="../archives.php?month='.$row['Month'].'&year='.$row['Year'].'">'.$monthName.' '.$row['Year'].'</a></li>';
}
?>
</ul>

<br />

	<h2>Under Construction</h2>
	<hr />
    <p>The site is still under progress, the pages or subdirectories may not be available yet, e.g. Archives.</p>
	
</aside>