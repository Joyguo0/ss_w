<?php

class FileExtension extends DataExtension {

	public function AbsoluteLink() {
//		Debug::show("YEAH");
		return Director::absoluteURL($this->owner->RelativeLink());
	}
	
	public function updateCMSFields(FieldList $fields){
		
		if ($this->owner instanceof Image){

			$data = '
				<button id="rotateImg" onclick="return doRotate(this);" style="float:left">
					<span class="btn-icon-arrow-circle-double">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</span>Rotate</button>
 				<script>
					var degrees=0;
					function doRotate(wHo){
						var elem=document.getElementById("thumbnailImage");
						degrees=degrees+90;
						if (degrees==360) degrees=0;  
					
						elem.style.WebkitTransform = "rotate("+degrees+"deg)";
						elem.style.MozTransform = "rotate("+degrees+"deg)";
						elem.style.msTransform = "rotate("+degrees+"deg)";
						elem.style.OTransform = "rotate("+degrees+"deg)";
						elem.style.transform = "rotate("+degrees+"deg)";
					
						wHo.form.Rotate.value=degrees;
						wHo.blur();
						return false;
					}
 				</script>
				';
		
			$fields->insertAfter(HiddenField::create('Rotate'),'ImageFull');		
			$fields->insertAfter(LiteralField::create('test',$data), 'ImageFull');
		}
	}
	public function onBeforeWrite() {
		parent::onBeforeWrite();
		if ( isset($_POST['Rotate'])) { 
			$val = (int)$_POST['Rotate'];
			if($val && ($val==90||$val==180||$val==270) ) {
				if ($val==90) $val=270; elseif ($val==270) $val=90; //rotation is backwards, how bizzare...?
				$original = new GD($this->owner->getFullPath());
				$image_loaded = (method_exists('GD', 'hasImageResource')) ? $original->hasImageResource() : $original->hasGD();
				if ($image_loaded) {
					$transformed = $original;
					$transformed = $transformed->rotate($val);
					$transformed->writeTo($this->owner->getFullPath());
					$this->owner->deleteFormattedimages();
				}
			}
		}
	}
}
