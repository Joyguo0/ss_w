<?php
/**
 * This component provides a checkbox which when checked enables drag-and-drop re-ordering of elements displayed in a {@link GridField}
 *
 * @package forms
 */
class IRXGridFieldSortableRows extends GridFieldSortableRows {

	protected $direction = false;
	
	/**
	 * @param String $sortColumn Column that should be used to update the sort information
	 */
	public function __construct($sortColumn, $direction = 'ASC') {
		$this->sortColumn 	= $sortColumn;
		$this->direction 	= $direction;
		
		parent::__construct($sortColumn);
	}
	public function getManipulatedData(GridField $gridField, SS_List $dataList) {
		//Detect and correct items with a sort column value of 0 (push to bottom)
		$this->fixSortColumn($gridField, $dataList);
		
		
		$headerState = $gridField->State->GridFieldSortableHeader;
		$state = $gridField->State->GridFieldSortableRows;
		if ((!is_bool($state->sortableToggle) || $state->sortableToggle==false) && $headerState && !empty($headerState->SortColumn)) {
			return $dataList;
		}
		
		if ($state->sortableToggle == true) {
			$gridField->getConfig()->removeComponentsByType('GridFieldFilterHeader');
			$gridField->getConfig()->removeComponentsByType('GridFieldSortableHeader');
		}
		
		return $dataList->sort($this->sortColumn, $this->direction);
	}
}
