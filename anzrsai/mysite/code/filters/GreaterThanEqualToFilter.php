<?php
/**
 * Selects numerical/date content greater than Equal to the input
*
* @todo documentation
*
* @package framework
* @subpackage search
*/
class GreaterThanEqualToFilter extends SearchFilter {
	/**
	 * @return DataQuery
	 */
	protected function applyOne(DataQuery $query) {
		$this->model = $query->applyRelation($this->relation);
		$value = $this->getDbFormattedValue();

		if(is_numeric($value)) $filter = sprintf("%s > %s", $this->getDbName(), Convert::raw2sql($value));
		else $filter = sprintf("%s >= '%s'", $this->getDbName(), Convert::raw2sql($value));
		
		return $query->where($filter);
	}

	/**
	 * @return DataQuery
	 */
	protected function excludeOne(DataQuery $query) {
		$this->model = $query->applyRelation($this->relation);
		$value = $this->getDbFormattedValue();

		if(is_numeric($value)) $filter = sprintf("%s < %s", $this->getDbName(), Convert::raw2sql($value));
		else $filter = sprintf("%s < '%s'", $this->getDbName(), Convert::raw2sql($value));
		
		return $query->where($filter);
	}
	
	public function isEmpty() {
		return $this->getValue() === array() || $this->getValue() === null || $this->getValue() === '';
	}
}
