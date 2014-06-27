<?php

class NewsletterEmailExtension extends DataExtension {

	public function onBeforeSend() {
		$this->owner->populateTemplate(new ArrayData(array(
			'Newsletter' => $this->owner->Newsletter()
		)));
		
	}
	

}
