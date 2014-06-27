<?php
class OptionExtension extends DataExtension {
	
	private static $has_one = array(
		'Image' => 'Image'
	);
	
	public function DescriptionForProduct(){
		$desc = $this->owner->Description;
		
		if($desc){
			$remove = array("\n", "\r\n", "\r");
			$desc = str_replace($remove, '<br>', $desc);
			
			while (stripos($desc, '<br><br>') !== false){
				$desc = str_replace('<br><br>', '<br>', $desc);
			}
		}
		
		return $desc;
	}
	
	

	public function updateCMSFields(FieldList $fields){
		
		$DescriptionField = $fields->dataFieldByName('Description');
		$DescriptionField->setRows(20);
		
		$IconAttrFolderName = 'Uploads';
		$AttrDO = $this->owner->Attribute();
		if($AttrDO->exists() && ( $AttrFolderDO = $AttrDO->Folder())){
			$IconAttrFolderName = $AttrFolderDO->exists() ? str_ireplace('assets/', '', $AttrFolderDO->Filename) : 'Uploads' ;
		}
		
		if( ! $this->owner->exists()){
			$fields->addFieldToTab('Root.Main', UploadField::create('Image', 'Icon')->setFolderName($IconAttrFolderName));
		}else{
			$fields->addFieldToTab('Root.Main', HeaderField::create('Add icon after saving it.'));
		}

	}
	
}