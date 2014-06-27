<?php
class NewsHolder extends Page {
	
	private static $icon = 'irxnews/images/icons/newsholder';
	
	private static $extensions = array(
		"ExcludeChildren"
	);
	
	private static $excluded_children = array(
		'News'
	);
	
	private static $db = array(
		'PaginationLimit' => 'Int'
	);
	
	
	private static $defaults = array(
			'PaginationLimit' => 5
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.Main', new NumericField('PaginationLimit', 'Pagination Limit'), 'Content');
		
		return $fields;
	}
	
	public function Children(){
		$children = parent::Children();
		
		foreach($children as $c){
			if($c->ClassName == 'News'){
				$children->remove($c);
			}
		}
		
		$page = new Page();
		$page->Title   = 'Archive';
		$page->MenuTitle  = 'Archive';
		$page->URLSegment = 'archive';
		$page->ParentID  = $this->ID;
		
		$children->unshift($page);
		return $children;
	}
}

class NewsHolder_Controller extends Page_Controller {
	
	protected $year;
	
	public static $allowed_actions = array(
		'archive',
		'rss',
		'index'
	);
	
	public static $url_handlers = array(
		'archive/$Year'		=> 'archive',
		'archive'			=> 'archive',
		'rss'				=> 'rss',
		'' 					=> 'index'
	);
	
	public function init() {
		parent::init();
		
		Requirements::javascript("irxnews/javascript/news.js");
		
		RSSFeed::linkToFeed($this->Link("rss"), "Latest News feed");
		
	}
	
	public function getOffset() {
		if(!isset($_REQUEST['start'])) {
			$_REQUEST['start'] = 0;
		}
		return $_REQUEST['start'];
	}
	
	public function index() {
		if(Director::is_ajax()) {
			$this->Ajax = true;
			return $this->renderWith('NewsList');
		}
		return array();
	}
	
	public function archive($request){
		$year = (int) $request->param('Year');

		if($year){
			$this->year = $year;
		}else{
			$this->year = date('Y');
		}
		
		$page = new Page();
		$page->Title 	 	 = 'archive';
		$page->MenuTitle 	 = 'archive';
		$this->extracrumbs[] = $page;
		
		$data = array(
			'Title' 	=> $this->year . ' News Archive',
			'Content' 	=> ''
		);
	
		return $this->customise($data)->renderWith(array('NewsHolder_archive', 'NewsHolder', 'Page'));
	}
	
	public function rss() {
		// Creates a new RSS Feed list
		$rss = new RSSFeed(
				$this->News(40), 
				$this->Link("rss"), 
				"Latest News feed"
		);
		// Outputs the RSS feed to the user.
		return $rss->outputToBrowser();
	}
	
	public function ArchiveNews(){
		$news = News::get()->sort('"Date" DESC')->where(DB::getConn()->formattedDatetimeClause('"Date"', '%Y') . " = $this->year" );
		return GroupedList::create($news);
	}
	
	public function News($overridePagination = null){
		
		if($overridePagination){
			$this->PaginationLimit = $overridePagination;
		}
		
		$news 				= News::get();
		$all_news_count 	= $news->count();
		$list 				= $news->limit($this->PaginationLimit, $this->getOffset());	
		$next 				= $this->getOffset() + $this->PaginationLimit;
		$this->MoreEvents 	= ($next < $all_news_count);
		$this->MoreLink 	= HTTP::setGetVar("start", $next);
		
		return $list;
	}
	
	public function Years() {
		$set   = new ArrayList();
		$year  = DB::getConn()->formattedDatetimeClause('"Date"', '%Y');
	
		$query = new SQLQuery();
		$query->setSelect("DISTINCT $year")->addFrom('"News"');
		$query->setOrderBy('"Date" DESC');
	
		$years = $query->execute()->column();
	
		if (!in_array(date('Y'), $years)) {
			array_unshift($years, date('Y'));
		}
	
		foreach ($years as $year) {
			$set->push(new ArrayData(array(
					'Year'    => $year,
					'Link'    => $this->Link("archive/" . $year . "/"),
					'Current' => $year == $this->year
			)));
		}
	
		return $set;
	}
	
	
}