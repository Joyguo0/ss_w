<?php
class AttributeExtension extends DataExtension {
	
	private static $db = array (
		'ImportMethod' 		=> "Enum('All,Select','Select')",
		'SelectedOptionIDs' => 'Varchar'
	);
	
	private static $has_one = array (
		'SelectedAttribute' => 'Attribute_Default',
		'Folder' => 'Folder'	
	);
	
	
	public function updateCMSFields(FieldList $fields) {
		
		$fields->removeByName('FolderID');
		
		if (! $this->owner->ID) {
			//we need this one to let program make decision in this onBeforeWrite function.
			$fields->addFieldToTab ( 'Root.Attribute',
					DropdownField::create (
							'ImportMethod',
							'Import Method',
							array(
								'Select' 	=> 'Import attribute with selected options',
								'All' 		=> 'Import attribute with all options'	
							),
							'Select'
					)->setHasEmptyDefault ( true ),
					'DefaultAttributeID'
			);
			
			
			//add display logic to the original DefaultAttributeID field
			$defaultAttrfield = $fields->dataFieldByName('DefaultAttributeID');
			$defaultAttrfield->displayIf ( "ImportMethod" )->isEqualTo ( 'All' )->end ();
			$defaultAttrfield->setTitle('Select existing attributes');
			
			
			//setup new dropdown field
			$defaultAttributes 	= Attribute_Default::get ();
			$attrIDsArray 		= $defaultAttributes->map( 'ID', 'Title' )->toArray ();
			
			$fields->addFieldToTab ( 'Root.Attribute', 
				DropdownField::create ( 
						'SelectedAttributeID', 
						'Select an existing attribute', 
						$attrIDsArray
				)->setHasEmptyDefault ( true )->displayIf ( "ImportMethod" )->isEqualTo ( 'Select' )->end (), 
				'AttributeOr' 
			);
			
			//setup options dropdown fields for each attribute
			foreach ( $attrIDsArray as $attrID => $attrTitle ) {
				$fields->addFieldToTab ( 'Root.Attribute', 
					CompositeField::create ( 
							ListboxField::create ( 
									"SelectedOptions[{$attrID}]", 
									"Options for '{$attrTitle}'", 
									$this->owner->getOptionsById ( $attrID ) )->setMultiple ( true ) 
					)->displayIf ( "SelectedAttributeID" )->isEqualTo ( $attrID )
						->andIf('ImportMethod')->isEqualTo ( 'Select' )->end (), 
					'AttributeOr' 
				);
			}
			
		}
		
	}
	
	
	public function onBeforeWrite() {
		
		$this->owner->firstWrite = ! $this->owner->isInDB();

		if ($this->owner->firstWrite) {
			//create folder for default attributes
			if($this->owner->ClassName == 'Attribute_Default' && ! $this->owner->FolderID){
				$iconFolder = Folder::get()->byID(39);
			
				if( ! $iconFolder->exists()){
					$iconFolder = Folder::find_or_make('Uploads/Tech-Specs-Icons');
				}
			
				$newFolder = new Folder();
				$newFolder->setTitle($this->owner->Title);
				$newFolder->ParentID = $iconFolder->ID;
				$newFolder->write();
			
				$this->owner->FolderID = $newFolder->ID;
			}
			
			if($this->owner->ImportMethod == 'Select'){
				
				$SelectedAttributeDO = $this->owner->SelectedAttribute();
				if ($SelectedAttributeDO && $SelectedAttributeDO->exists()) {
					$this->owner->Title 		= $SelectedAttributeDO->Title;
					$this->owner->Description 	= $SelectedAttributeDO->Description;
				}
				
				//reset DefaultAttributeID to 0, so that the default onAfterWrite function won't import all options.
				$this->owner->DefaultAttributeID = 0;

				//going to get the selected options.
				$SelectedOptions = Controller::curr ()->getRequest ()->postVar ('SelectedOptions');
				
// 				$SelectedOptions Array structure sample
// 					array (size=2)
// 					  2 => 		//// '2' is attribute ID
// 					    array (size=3)
// 					      0 => string '6' (length=1)	////'6', '7' and '8' are the select options for attribute ID '2'
// 					      1 => string '8' (length=1)
// 					      2 => string '9' (length=1)
// 					  3 => 								//// please note, most of time, 
// 					    array (size=4)					//// there will be only one value for $SelectedOptions.
// 					      0 => string '15' (length=2)	//// But this will happen if user select switch attribute
// 					      1 => string '17' (length=2)	//// and select again.
// 					      2 => string '18' (length=2)
// 					      3 => string '19' (length=2)
				
				if(isset($SelectedOptions[$this->owner->SelectedAttributeID])){
					//save selected options ID as a string
					$this->owner->SelectedOptionIDs = implode(',', $SelectedOptions[$this->owner->SelectedAttributeID]);
				}else{
					$this->owner->SelectedOptionIDs = 0;
				}
				
			}
			
			//if they choose import 'All' options. then let the program do the default process.

		}
	}
	
	public function onAfterWrite() {
		
		if ($this->owner->firstWrite) {
	
			if($this->owner->ImportMethod == 'Select' && $this->owner->SelectedOptionIDs){
				$optionIDsArray = explode(',', $this->owner->SelectedOptionIDs);
			
				$optionsDL		= Option::get()->byIDs($optionIDsArray);
				
				//save attribute info
				$SelectedAttributeDO = $this->owner->SelectedAttribute();
				if ($SelectedAttributeDO && $SelectedAttributeDO->exists()) {
					if ($optionsDL && $optionsDL->exists()) foreach ($optionsDL as $option) {
						$newOption = new Option();
						
						$optionDataArray = $option->toMap();
						unset($optionDataArray['ID']);
						unset($optionDataArray['ClassName']);
						unset($optionDataArray['Created']);
						unset($optionDataArray['LastEdited']);
						
						$newOption->update($optionDataArray);
						$newOption->ID = null;
						$newOption->AttributeID = $this->owner->ID;
						$newOption->write();
					}
				}
				
			}

		}
	
	}
	
}