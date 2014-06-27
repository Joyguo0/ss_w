<?php

	$uploaddir = dirname($_SERVER['SCRIPT_FILENAME'])."/";

	
	if(count($_FILES) > 0)
	{
		$arrfile = pos($_FILES);
		$uploadfile = $uploaddir . basename($arrfile['name']);
		
		if (move_uploaded_file($arrfile['tmp_name'], $uploadfile)){
			$rotang  = 270;
			$source = imagecreatefrompng($uploadfile) or die('Error opening file '.$uploadfile);
			imagealphablending($source, false);
			imagesavealpha($source, true);

			$rotation = imagerotate($source, $rotang, imageColorAllocateAlpha($source, 0, 0, 0, 127));
			imagealphablending($rotation, false);
			imagesavealpha($rotation, true);

			imagepng($rotation,$uploadfile);
			imagedestroy($source);
			imagedestroy($rotation);
			echo "<img src='" . basename($arrfile['name']) . "'/>";
		}
		

	}
	echo '<br>'; // At least one symbol should be sent to response!!!


?> 