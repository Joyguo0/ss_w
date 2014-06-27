<?php
class SiteConfigToggleCompositeField extends ToggleCompositeField {

	public function FieldHolder($properties = array()) {
		Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery/jquery.js');
		Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery-ui/jquery-ui.js');
		Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery-entwine/dist/jquery.entwine-dist.js');
		Requirements::javascript('mysite/javascript/SiteConfigToggleCompositeField.js');
		Requirements::css(FRAMEWORK_DIR . '/thirdparty/jquery-ui-themes/smoothness/jquery.ui.css');

		$obj = $properties ? $this->customise($properties) : $this;
		return $obj->renderWith($this->getTemplates());
	}

}

