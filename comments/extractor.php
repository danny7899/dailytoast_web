<?php
class extractor {

	public $cmtx_link = '/';
	public $cmtx_mysql_table_prefix = '';
	public $cmtx_path = '/';

	function __construct($cmtx_path) {
	
		global $cmtx_link; global $cmtx_mysql_table_prefix; global $cmtx_path; global $cmtx_db_ok;

		require_once $cmtx_path . 'includes/db/connect.php';
		
		$cmtx_db_ok = true;
		
		$this->setLink($cmtx_link);
		
		$this->setPrefix($cmtx_mysql_table_prefix);
		
		$this->setPath($cmtx_path);
		
	}

	public function newestComments() {
	
		$html = '';

		$comments = mysqli_query($this->getLink(), "SELECT * FROM `" . $this->getPrefix() . "comments` WHERE `is_approved` = '1' ORDER BY `dated` DESC LIMIT 5");

		while ($comment = mysqli_fetch_array($comments)) {

			$page_query = mysqli_query($this->getLink(), "SELECT * FROM `" . $this->getPrefix() . "pages` WHERE `id` = '" . $comment["page_id"] . "'");
			$page = mysqli_fetch_assoc($page_query);

			$html .= $comment["name"] . " on <a href='" . $page["url"] . "?cmtx_perm=" . $comment["id"] . "#cmtx_perm_" . $comment["id"] . "'>" . $page["reference"] . "</a> at " . date("g:ia (jS-M)", strtotime($comment["dated"]));
			$html .= '<br/>';
			
		}
		
		return $html;
		
	}
	
	public function likedComments() {
	
		$html = '';

		$comments = mysqli_query($this->getLink(), "SELECT * FROM `" . $this->getPrefix() . "comments` WHERE `is_approved` = '1' ORDER BY `likes` DESC LIMIT 5");

		while ($comment = mysqli_fetch_array($comments)) {

			$page_query = mysqli_query($this->getLink(), "SELECT * FROM `" . $this->getPrefix() . "pages` WHERE `id` = '" . $comment["page_id"] . "'");
			$page = mysqli_fetch_assoc($page_query);

			$html .= $comment["name"] . " on <a href='" . $page["url"] . "?cmtx_perm=" . $comment["id"] . "#cmtx_perm_" . $comment["id"] . "'>" . $page["reference"] . "</a> at " . date("g:ia (jS-M)", strtotime($comment["dated"]));
			$html .= '<br/>';
			
		}
		
		return $html;
		
	}
	
	public function positiveComments() {
	
		$html = '';

		$comments = mysqli_query($this->getLink(), "SELECT * FROM `" . $this->getPrefix() . "comments` WHERE `is_approved` = '1' ORDER BY `rating` DESC LIMIT 5");

		while ($comment = mysqli_fetch_array($comments)) {

			$page_query = mysqli_query($this->getLink(), "SELECT * FROM `" . $this->getPrefix() . "pages` WHERE `id` = '" . $comment["page_id"] . "'");
			$page = mysqli_fetch_assoc($page_query);

			$html .= $comment["name"] . " on <a href='" . $page["url"] . "?cmtx_perm=" . $comment["id"] . "#cmtx_perm_" . $comment["id"] . "'>" . $page["reference"] . "</a> at " . date("g:ia (jS-M)", strtotime($comment["dated"]));
			$html .= '<br/>';
			
		}
		
		return $html;
		
	}
	
	public function viewedPages() {
	
		$html = '';
	
		$pages = mysqli_query($this->getLink(), "SELECT `page_reference`, `page_url`, SUM(`timestamp`) as `time` FROM `" . $this->getPrefix() . "viewers` GROUP BY `page_reference` ORDER BY `time` DESC LIMIT 5");

		while ($page = mysqli_fetch_assoc($pages)) {

			$html .= "<a href='" . $page["page_url"] . "'>" . $page["page_reference"] . "</a>";
			$html .= '<br/>';

		}
		
		return $html;
	
	}
	
	public function ratedPages() {
	
		$html = '';
	
		$comments = mysqli_query($this->getLink(), "SELECT `page_id`, AVG(`rating`) AS `average` FROM `" . $this->getPrefix() . "comments` WHERE `is_approved` = '1' AND `rating` != '0' GROUP BY `page_id` ORDER BY `average` DESC LIMIT 5");

		while ($comment = mysqli_fetch_assoc($comments)) {

			$average = round($comment["average"] / 0.5) * 0.5;

			$page_query = mysqli_query($this->getLink(), "SELECT * FROM `" . $this->getPrefix() . "pages` WHERE `id` = '" . $comment["page_id"] . "'");
			$page = mysqli_fetch_assoc($page_query);
			
			$html .= "<a href='" . $page["url"] . "'>" . $page["reference"] . "</a> (" . $average . "/5)";
			$html .= '<br/>';

		}
		
		return $html;
	
	}
	
	public function postedPages() {
	
		$html = '';
	
		$comments = mysqli_query($this->getLink(), "SELECT `page_id`, COUNT(`page_id`) AS `total` FROM `" . $this->getPrefix() . "comments` WHERE `is_approved` = '1' GROUP BY `page_id` ORDER BY `total` DESC LIMIT 5");

		while ($comment = mysqli_fetch_assoc($comments)) {

			$page_query = mysqli_query($this->getLink(), "SELECT * FROM `" . $this->getPrefix() . "pages` WHERE `id` = '" . $comment["page_id"] . "'");
			$page = mysqli_fetch_assoc($page_query);
			
			$html .= "<a href='" . $page["url"] . "'>" . $page["reference"] . "</a> (" . $comment["total"] . ")";
			$html .= '<br/>';

		}
		
		return $html;
	
	}
	
	public function topPosters() {
	
		$html = '';
	
		$names = mysqli_query($this->getLink(), "SELECT `name`, COUNT(`name`) AS `total` FROM `" . $this->getPrefix() . "comments` WHERE `is_approved` = '1' GROUP BY `name` ORDER BY `total` DESC LIMIT 5");

		while ($name = mysqli_fetch_assoc($names)) {
			
			$html .= $name["name"] . " (" . $name["total"] . ")";
			$html .= '<br/>';

		}
		
		return $html;
	
	}
	
	public function commentCount($cmtx_identifier) {
	
		$cmtx_identifier = mysqli_real_escape_string($this->getLink(), $cmtx_identifier);
		
		$page_query = mysqli_query($this->getLink(), "SELECT `id` FROM `" . $this->getPrefix() . "pages` WHERE `identifier` = '" . $cmtx_identifier . "'");
		$page = mysqli_fetch_assoc($page_query);
		$id = $page['id'];
		
		$count_query = mysqli_query($this->getLink(), "SELECT * FROM `" . $this->getPrefix() . "comments` WHERE is_approved = '1' AND page_id = '" . $id . "'");
		$count = mysqli_num_rows($count_query);
		
		if ($count) {
			if ($count == 1){
				return $count." comment";
			} else {
				return $count." comments";
			}
		
		} else {
		
			return '0 comments';
		
		}
	
	}
	
	public function commentCountInt($cmtx_identifier) {
	
		$cmtx_identifier = mysqli_real_escape_string($this->getLink(), $cmtx_identifier);
		
		$page_query = mysqli_query($this->getLink(), "SELECT `id` FROM `" . $this->getPrefix() . "pages` WHERE `identifier` = '" . $cmtx_identifier . "'");
		$page = mysqli_fetch_assoc($page_query);
		$id = $page['id'];
		
		$count_query = mysqli_query($this->getLink(), "SELECT * FROM `" . $this->getPrefix() . "comments` WHERE is_approved = '1' AND page_id = '" . $id . "'");
		$count = mysqli_num_rows($count_query);
		
		
		return $count;
		
	
	}

	
	public function pageRating($cmtx_identifier) {
	
		$cmtx_identifier = mysqli_real_escape_string($this->getLink(), $cmtx_identifier);

		$page_query = mysqli_query($this->getLink(), "SELECT `id` FROM `" . $this->getPrefix() . "pages` WHERE `identifier` = '" . $cmtx_identifier . "'");
		$page = mysqli_fetch_assoc($page_query);
		$id = $page['id'];

		$result = mysqli_query($this->getLink(), "SELECT AVG(`rating`) 
			FROM ( 
			SELECT `rating` FROM `" . $this->getPrefix() . "comments` WHERE `is_approved` = '1' AND `rating` != '0' AND `page_id` = '" . $id . "' 
			UNION ALL 
			SELECT `rating` FROM `" . $this->getPrefix() . "ratings` WHERE `page_id` = '" . $id . "' 
			) 
			AS `average`
			");

		$average = mysqli_fetch_assoc($result);
		
		$average = $average["AVG(`rating`)"];
		
		$multiplier = 20;
		
		$average = $average * $multiplier;
		
		$average = round($average, 0);
		
		if ($average) {
		
			return '<span class="rating" data-rating="'.$average.'" data-star="★★★★★"></span>';
		
		} else {
		
			return 'no ratings';
		
		}
	
	}
	
	public function pageRatingWithStars($cmtx_identifier) {
	
		$html = '';
	
		$cmtx_identifier = mysqli_real_escape_string($this->getLink(), $cmtx_identifier);

		$page_query = mysqli_query($this->getLink(), "SELECT `id` FROM `" . $this->getPrefix() . "pages` WHERE `identifier` = '" . $cmtx_identifier . "'");
		$page = mysqli_fetch_assoc($page_query);
		$id = $page['id'];

		$result = mysqli_query($this->getLink(), "SELECT AVG(`rating`) 
			FROM ( 
			SELECT `rating` FROM `" . $this->getPrefix() . "comments` WHERE `is_approved` = '1' AND `rating` != '0' AND `page_id` = '" . $id . "' 
			UNION ALL 
			SELECT `rating` FROM `" . $this->getPrefix() . "ratings` WHERE `page_id` = '" . $id . "' 
			) 
			AS `average`
			");

		$average = mysqli_fetch_assoc($result);
		
		$average = $average["AVG(`rating`)"];
		
		$average = round($average, 0);
		
		$query = mysqli_query($this->getLink(), "SELECT * FROM `" . $this->getPrefix() . "comments` WHERE `page_id` = '" . $id . "' AND `rating` != '0' AND `is_approved` = '1'");
		$total_1 = mysqli_num_rows($query);

		$query = mysqli_query($this->getLink(), "SELECT * FROM `" . $this->getPrefix() . "ratings` WHERE `page_id` = '" . $id . "'");
		$total_2 = mysqli_num_rows($query);

		$votes = $total_1 + $total_2;

		if ($average && $votes) {

		$html .= '<div itemscope itemtype="http://data-vocabulary.org/Review-aggregate">';
		$html .= '<span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">';

		if ($average == 1) {
			$html .= '<img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_empty.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_empty.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_empty.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_empty.png" alt=""> <span itemprop="average">1</span>/<span itemprop="best">5</span></span>';
		} elseif ($average == 2) {
			$html .= '<img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_empty.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_empty.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_empty.png" alt=""> <span itemprop="average">2</span>/<span itemprop="best">5</span></span>';
		}  elseif ($average == 3) {
			$html .= '<img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_empty.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_empty.png" alt=""> <span itemprop="average">3</span>/<span itemprop="best">5</span></span>';
		}  elseif ($average == 4) {
			$html .= '<img src="' . $this->getPath() . 'images/stars/star_full.png" alt="" ><img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_empty.png" alt=""> <span itemprop="average">4</span>/<span itemprop="best">5</span></span>';
		}  else {
			$html .= '<img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""><img src="' . $this->getPath() . 'images/stars/star_full.png" alt=""> <span itemprop="average">5</span>/<span itemprop="best">5</span></span>';
		}

		$html .= ' (<span itemprop="votes">' . $votes . '</span>)';
		$html .= '</div>';

		} else {
			$html .= 'No ratings yet.';
		}
		
		return $html;
	
	}

	private function setLink($cmtx_link) {
		$this->cmtx_link = $cmtx_link;
	}

	private function getLink() {
		return $this->cmtx_link;        
	}
	
	private function setPrefix($cmtx_mysql_table_prefix) {
		$this->cmtx_prefix = $cmtx_mysql_table_prefix;
	}

	private function getPrefix() {
		return $this->cmtx_prefix;        
	}
	
	private function setPath($cmtx_path) {
		$this->cmtx_path = $cmtx_path;
	}

	private function getPath() {
		return $this->cmtx_path;        
	}

}
?>