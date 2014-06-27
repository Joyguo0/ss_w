<?php
/**
* File class represent file item 
*/
class File 
{
		/**
    	 * File name    	 
    	 */
        public $id;
		
    	/**
    	 * File name    	 
    	 */
        public $name;
		
        /**
         * File size
         */
        public $size;		
		
		/**
         * File date
         */
        public $modificationDate;

        /**
         * Url to file
         */
        public $url;
        
		public function __construct($_name, $_size, $_date, $_downloadUrl, $_thumbnailUrl)
        {            
			$this->id = "";      
            $this->name = $_name;            
			$this->size = $_size;
			$this->modificationDate = $_date;
			$this->url = $_downloadUrl;		
			$this->thumbnailUrl = $_thumbnailUrl;
        }
}	
	
ini_set("error_reporting", ~E_ALL);
//PHP script that generate files list for MultiPowUpload
//2012. Element-IT software.
$source_dir = dirname($_SERVER['SCRIPT_FILENAME'])."/UploadedFiles/";
$url_prefix=  dirname($_SERVER['PHP_SELF'])."/UploadedFiles/";
//file names encoding on server side. All file and folder names should encoded into utf-8
$source_encoding = "cp1252";

header('Content-Type: text/javascript');
	
writeContent($source_dir);

flush();

	
function writeContent($parent)
{
	GLOBAL $source_dir, $source_encoding, $url_prefix;
	$have_files = false;	
	$files = Array();
	if($handle = opendir($parent))
	{
	    rewinddir($handle);
		while (false !== ($file = readdir($handle)))
	    {
	        if ($file != "." && $file != "..")
	    	{
	        	if(is_file($parent.$file))
	        	{	
					$have_files = true;
					$download_url = iconv($source_encoding,"UTF-8",$url_prefix.rawurlencode($file));
					$thumbnail_url = "";
					if(is_file($parent."thumbnail_".$file))
						$thumbnail_url = iconv($source_encoding,"UTF-8",$url_prefix.rawurlencode("thumbnail_".$file));
					$filec = new File(iconv($source_encoding,"UTF-8", $file), filesize($parent.$file), date("r", filemtime($parent.$file)), $download_url, $thumbnail_url);
					/*
					* Set id if needed 
					* $file->id
					*/
					
					/**
					* Files which name starts with "thumbnail_" prefix (and there is file without this prefix) are ignored.
					* Comment line below to add all files into list. 
					*/
					//echo (strpos($file, "thumbnail_") )." ".is_file($parent.substr($file, strlen("thumbnail_")))." ". $file." - ".substr($file, strlen("thumbnail_"))."</br>";
					if(!(strpos($file, "thumbnail_") === 0 && is_file($parent.substr($file, strlen("thumbnail_")))))						
						$files[] = $filec;
	         	}
	        }
	    }	    
	    closedir($handle);
	}	
	echo json_encode($files);
}	
	


?>
