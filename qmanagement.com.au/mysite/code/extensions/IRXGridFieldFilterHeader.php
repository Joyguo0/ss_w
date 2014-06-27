<?php
/**
 * GridFieldFilterHeader alters the gridfield with some filtering fields in the header of each column
 * 
 * @see GridField
 * 
 * @package framework
 * @subpackage fields-relational
 */
class IRXGridFieldFilterHeader extends GridFieldFilterHeader {

	public function handleAction(GridField $gridField, $actionName, $arguments, $data) {
		if(!$this->checkDataType($gridField->getList())) return;

		$state = $gridField->State->GridFieldFilterHeader;
		
		//jason//
		$FilterName = $gridField->name . '-filter';
		//
		
		if($actionName === 'filter') {
			if(isset($data[$FilterName])){
				foreach($data[$FilterName] as $key => $filter ){
					$state->Columns->$key = $filter;
				}
			}
		} elseif($actionName === 'reset') {
			$state->Columns = null;
		}
	}

	public function getHTMLFragments($gridField) {
		if(!$this->checkDataType($gridField->getList())) return;

		$GridFieldName = $gridField->name;	//jason//
		
		$forTemplate = new ArrayData(array());
		$forTemplate->Fields = new ArrayList;
		$columns = $gridField->getColumns();
		$filterArguments = $gridField->State->GridFieldFilterHeader->Columns->toArray();
		$currentColumn = 0;
		foreach($columns as $columnField) {
			$currentColumn++;
			$metadata = $gridField->getColumnMetadata($columnField);
			$title = $metadata['title'];
			$fields = new FieldGroup();
			
			if($title && $gridField->getList()->canFilterBy($columnField)) {
				$value = '';
				if(isset($filterArguments[$columnField])) {
					$value = $filterArguments[$columnField];
				}
				$field = new TextField($GridFieldName.'-filter['.$columnField.']', '', $value);	//jason//
				$field->addExtraClass('ss-gridfield-sort');
				$field->addExtraClass('no-change-track');

				$field->setAttribute('placeholder',
					_t('GridField.FilterBy', "Filter by ") . _t('GridField.'.$metadata['title'], $metadata['title']));

				$fields->push($field);
				$fields->push(
					GridField_FormAction::create($gridField, 'reset', false, 'reset', null)
						->addExtraClass('ss-gridfield-button-reset')
						->setAttribute('title', _t('GridField.ResetFilter', "Reset"))
						->setAttribute('id', 'action_reset_' . $gridField->getModelClass() . '_' . $columnField)
				);
			} 

			if($currentColumn == count($columns)){
				$fields->push(
					GridField_FormAction::create($gridField, 'filter', false, 'filter', null)
						->addExtraClass('ss-gridfield-button-filter')
						->setAttribute('title', _t('GridField.Filter', "Filter"))
						->setAttribute('id', 'action_filter_' . $gridField->getModelClass() . '_' . $columnField)
				);
				$fields->push(
					GridField_FormAction::create($gridField, 'reset', false, 'reset', null)
						->addExtraClass('ss-gridfield-button-close')
						->setAttribute('title', _t('GridField.ResetFilter', "Reset"))
						->setAttribute('id', 'action_reset_' . $gridField->getModelClass() . '_' . $columnField)
				);
				$fields->addExtraClass('filter-buttons');
				$fields->addExtraClass('no-change-track');
			}

			$forTemplate->Fields->push($fields);
		}

		return array(
			'header' => $forTemplate->renderWith('GridFieldFilterHeader_Row'),
		);
	}
}
