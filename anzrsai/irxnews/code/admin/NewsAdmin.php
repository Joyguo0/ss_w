<?php
class NewsAdmin extends ModelAdmin {
	
	private static $title       = 'News';
	private static $menu_title  = 'News';
	private static $url_segment = 'news';

	private static $managed_models  = 'News';
	private static $model_importers = array();
	
	public function getSearchContext() {
		$context = parent::getSearchContext();
		if($this->modelClass == 'News') {
			$context->getFields()->push(DropdownField::create('q[Status]', 'Status', array('Published' => "Published", 'Unpublished' => "Unpublished"))
					->setHasEmptyDefault(true));
		}
		return $context;
	}
	
	public function getList() {
		$list = parent::getList();
		$params = $this->request->requestVar('q'); // use this to access search parameters
	
		if($this->modelClass == 'News') {
				
			if(isset($params['Status']) && $params['Status']){
				$ids = DB::query("SELECT \"ID\" FROM \"News_Live\"")->keyedColumn();
					
				if($params['Status'] == "Published"){
					$list = $list->filter('ID', $ids);
				}else{
					$list = $list->exclude('ID', $ids);
				}
			}
	
			$list = $list->sort('"NewsModelAdmin"."Date"', 'DESC');
			$list = $list->leftJoin('News', '"SiteTree"."ID" = "NewsModelAdmin"."ID"', "NewsModelAdmin");
		}
	
		return $list;
	}

}

