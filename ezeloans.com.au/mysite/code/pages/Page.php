<?php
/**
 *
 */
class Page extends SiteTree {
	
	public function LoanPages($number = null) {
		$c=LoanPage::get ();
		return LoanPage::get ();
	}
	
	public function LoadPreApprovalPage(){
		return ApprovalFormPage::get()->first();
	}
	public function getHeaderName(){
		if($this->ClassName=="HomePage" && isset($_GET['Search'])){
			return 'basic';
		}else if($this->ClassName=="LandingPage"){
			return 'LandingPage';
		}else if($this->ClassName=="HomePage"){
			return 'HomePage';
		}else{
			return 'basic';
		}
		
	}
	
}

class Page_Controller extends ContentController {
	
	public $ThemeDir = '';
	
	public function init() {
		parent::init ();
		
		Requirements::block(FRAMEWORK_DIR .'/thirdparty/jquery/jquery.js');
		
		$this->ThemeDir = 'themes/' . SSViewer::current_theme () . '/';
		
		Requirements::css($this->ThemeDir . 'fonts/proxima-nova.css');
		Requirements::css($this->ThemeDir . 'style.css');
		
		Requirements::combine_files(
			'page.css',
			array(
				$this->ThemeDir . 'css/onepcssgrid.css',
				$this->ThemeDir . 'css/typography.css',
				$this->ThemeDir . 'bestmenu/drop/superfish.css',
				$this->ThemeDir . 'bestmenu/mobile/meanmenu.css'
			)
		);
		
		Requirements::combine_files(
			'page.js',
			array(
				$this->ThemeDir . 'js/jquery.min.js',
				$this->ThemeDir . 'bestmenu/drop/superfish.js',
				$this->ThemeDir . 'bestmenu/drop/hoverIntent.js',
				$this->ThemeDir . 'bestmenu/mobile/jquery.meanmenu.js',
				$this->ThemeDir . 'plugins/skrollr/skrollr.js',
				$this->ThemeDir . 'js/ezeloan.js'
			)
		);
		
	}
	
	
	
	
	
}
