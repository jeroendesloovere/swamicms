<?php

/**
* export
*
* to excel
* to csv
* to zip
* to pdf
* to qr
*
* @author: Jeroen Desloovere
* @date: 	9/11/2010 
*/
class export_model
{
	private static $filename;
		
	// ------------------------------------------
	// Filename
	// ------------------------------------------
	public function filename($filename=''){
		if(!empty($filename)) self::$filename = $filename;
		if(empty(self::$filename)) self::$filename = 'naamloos-'.date('Ymd_H:i:s');
		return self::$filename;
	}
	
	// Download header
	// ------------------------------------------
	public function setDownloadHeader($filename){
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=".$filename."");
		header("Content-Transfer-Encoding: binary");
	}
	
	// ------------------------------------------
	// Types of export
	// ------------------------------------------	
	// Excel
	// ------------------------------------------
	public function excel(){
		return load::model('export/excel');
	}
		
	// Csv
	// ------------------------------------------
	public function csv(){
		return load::model('export/csv');
	}
	
	// Zip
	// ------------------------------------------
	public function zip(){
		return load::model('export/zip');
	}
	
	// Pdf
	// ------------------------------------------
	public function pdf(){
		return load::model('export/pdf');
	}
	
	// QR-code
	// ------------------------------------------
	public function qrcode(){
		return load::model('export/qrcode');
	}
}
?>