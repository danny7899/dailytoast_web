<!DOCTYPE html>
<html>
<head>
<title>Example</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>

<h1>Example</h1>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus posuere sodales condimentum. Vestibulum ut felis nec tortor pharetra blandit et vel nunc. Sed nec ligula ac orci scelerisque lobortis quis et velit. Pellentesque tristique ligula mattis neque dignissim aliquam. Duis suscipit accumsan libero, nec fringilla urna consequat non. Fusce consequat eros vitae nunc eleifend cursus. Etiam ornare rhoncus ligula, ac pretium ipsum blandit eu. Duis mattis dapibus lorem, ut euismod lorem semper id. Aenean dapibus dapibus odio eget ullamcorper. Pellentesque non tincidunt est. Pellentesque ultricies, nisl id dictum blandit, augue dolor dictum lorem, vel lobortis urna magna nec lorem. Aenean dignissim turpis sit amet mi ultricies tempus. Phasellus vel ante in tortor hendrerit aliquam sit amet sed urna. Ut pharetra odio quis dui vestibulum facilisis et a lectus. 編碼.</p>

<?php
$cmtx_path = 'comments/';

require_once 'comments/extractor.php';

$extractor = new extractor($cmtx_path);

// Newest Comments
echo "<h3>Newest Comments</h3>";
echo $extractor->newestComments();

// Liked Comments
echo "<h3>Liked Comments</h3>";
echo $extractor->likedComments();

// Positive Comments
echo "<h3>Positive Comments</h3>";
echo $extractor->positiveComments();

// Viewed Pages
echo "<h3>Viewed Pages</h3>";
echo $extractor->viewedPages();

// Rated Pages
echo "<h3>Rated Pages</h3>";
echo $extractor->ratedPages();

// Posted Pages
echo "<h3>Posted Pages</h3>";
echo $extractor->postedPages();

// Top Posters
echo "<h3>Top Posters</h3>";
echo $extractor->topPosters();

// Comment Count
echo "<h3>Comment Count</h3>";
echo $extractor->commentCount('1'); //$cmtx_identifier

// Page Rating
echo "<h3>Page Rating</h3>";
echo $extractor->pageRating('1'); //$cmtx_identifier

// Page Rating (Stars)
echo "<h3>Page Rating (Stars)</h3>";
echo $extractor->pageRatingWithStars('1'); //$cmtx_identifier
?>

</body>
</html>