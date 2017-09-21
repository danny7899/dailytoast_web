<h1>Recent Posts</h1>
<hr />

<ul>
<?php
$stmt = $db->query('SELECT postTitle, postSlug FROM blog_posts_seo ORDER BY postID DESC LIMIT 5');
while($row = $stmt->fetch()){
    echo '<li><a href="viewpost.php?id='.$row['postSlug'].'">'.$row['postTitle'].'</a></li>';
}
?>
</ul>


<h1>Categories</h1>
<hr />

<ul>
<?php
$stmt = $db->query('SELECT catTitle, catSlug FROM blog_cats ORDER BY catID DESC');
while($row = $stmt->fetch()){
    echo '<li><a href="catpost.php?id='.$row['catSlug'].'">'.$row['catTitle'].'</a></li>';
}
?>
</ul>


<h1>Archives</h1>
<hr />
<ul>
<?php
$stmt = $db->query("SELECT Month(postDate) as Month, Year(postDate) as Year FROM blog_posts_seo GROUP BY Month(postDate), Year(postDate) ORDER BY postDate DESC");
while($row = $stmt->fetch()){
    $monthName = date("F", mktime(0, 0, 0, $row['Month'], 10));
    echo '<li><a href="archives.php?month='.$row['Month'].'&year='.$row['Year'].'">'.$monthName.' '.$row['Year'].'</a></li>';
}
?>
</ul>