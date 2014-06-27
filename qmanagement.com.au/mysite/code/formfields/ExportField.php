<?php

class ExportField extends TextField
{

    /**
     *
     * @var int
     */
    protected $Pageobj;

    public static $allowed_actions = array(
            'downloadPage',
            'toZip'
    );

    /**
     * Returns an input field, class="text" and type="text" with an optional
     * maxlength
     */
    public function __construct ($name, $title = null, $Pageobj)
    {
        $this->Pageobj = $Pageobj;
        parent::__construct($name, $title);
    }

    public function downloadPage ($request)
    {
        $file=$request->getVar('file');
        if($file){
            header("Cache-Control: public");
            header("Content-Description: FileTransfer");
            header('Content-disposition: attachment;filename=' . basename($file)); // 文件名
            header("Content-Type: application/zip"); // zip格式的
            header("Content-Transfer-Encoding:binary"); // 告诉浏览 器，这是二进制文件
            header('Content-Length: ' . filesize($file)); // 告诉浏览 器，文件大小
            @readfile($file);
        }
    }
    public function toZip(){
        $filename = $this->Pageobj->Title.date('YmdHis',time());
        $dir = Director::baseFolder()."/assets/export/$filename/";
         
        $url = Director::absoluteURL($this->Pageobj->Link()).'?suffix=0';
        
        $commod = " wget --no-parent --convert-links --no-directories  --page-requisites -erobots=off -P $dir $url";
         system($commod);
        return json_encode($this->zip($dir,$filename.'.zip'));
    }

    function zip ($dir, $filename, $missfile = array(), $addfromString = array())
    {
        $result=array('flag'=>false,'msg'=>false);
        if (! file_exists($dir) || ! is_dir($dir)) {
            $result['msg']=' can not exists dir ' . $dir;
            return $result;
        }
        $s=explode('.', $filename);
        if (strtolower(end($s)) != 'zip') {
            $result['msg']='only Support zip files';
            return $result;
        }
        if (file_exists($dir.$filename)) {
            $result['msg']='the zip file ' . $filename . ' has exists !';
            return $result;
        }
        $files = array();
        $this->getfiles($dir, $files);
  
        if (empty($files)) {
            $result['msg']=' the dir is empty';
            return $result;
        }
        
        $zip = new ZipArchive();
        $res = $zip->open($dir.$filename, ZipArchive::CREATE);
        if ($res === TRUE) {
            foreach ($files as $v) {
                if (! in_array(str_replace($dir . '/', '', $v), $missfile)) {
                    $toname=basename($v);
                    if($toname=="index.html?suffix=0"){
                       $toname='index.html';
                    }
                    $zip->addFile($v,$toname);
                }
            }
            if (! empty($addfromString)) {
                foreach ($addfromString as $v) {
                    $zip->addFromString($v[0], $v[1]);
                }
            }
            $zip->close();
            $result['msg']=$dir.$filename;
            $result['flag']=true;
            return $result;
        } else {
            $result['msg']='can open '.$dir.$filename;
            return $result;
        }
    }

    function getfiles ($dir, &$files = array())
    {
        if (! file_exists($dir) || ! is_dir($dir)) {
            return;
        }
        if (substr($dir, - 1) == '/') {
            $dir = substr($dir, 0, strlen($dir) - 1);
        }
        $_files = scandir($dir);
        foreach ($_files as $v) {
            if ($v != '.' && $v != '..') {
                if (is_dir($dir . '/' . $v)) {
                    getfiles($dir . '/' . $v, $files);
                } else {
                    $files[] = $dir . '/' . $v;
                }
            }
        }
        return $files;
    }
}