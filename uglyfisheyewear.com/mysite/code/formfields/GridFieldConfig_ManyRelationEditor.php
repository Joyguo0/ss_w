<?php 

class GridFieldConfig_ManyRelationEditor extends GridFieldConfig {
	/**
	 *
	 * @param int $itemsPerPage - How many items per page should show up
	 */
	public function __construct($itemsPerPage=null) {
		
		$this->addComponent(new GridFieldButtonRow('before'));
		$this->addComponent(new GridFieldAddNewButton('buttons-before-left'));
		$this->addComponent(new GridFieldAddExistingAutocompleter('buttons-before-left'));
		$this->addComponent(new GridFieldToolbarHeader());
		$this->addComponent($sort = new GridFieldSortableHeader());
		$this->addComponent(new GridFieldDataColumns());
		$this->addComponent(new GridFieldEditButton());
		$this->addComponent(new GridFieldDeleteAction(true));
		$this->addComponent(new GridFieldPageCount('toolbar-header-right'));
		
		//my custom components
		$this->addComponent(new IRXGridFieldManyRelationHandler());
		
		$this->addComponent($filter = new GridFieldFilterHeader());
		
		$this->addComponent($pagination = new GridFieldPaginator($itemsPerPage));
		$this->addComponent(new GridFieldDetailForm());

		$sort->setThrowExceptionOnBadDataType(false);
		$filter->setThrowExceptionOnBadDataType(false);
		$pagination->setThrowExceptionOnBadDataType(false);
	}
}

