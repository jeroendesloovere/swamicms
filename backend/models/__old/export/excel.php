<?php
class excel_model extends export_model
{
	const EXTENSION = '.xls';
	
	private static $data;
	private static $keys;
	private static $labels;
	private static $title;
	
	// Data
	// ------------------------------------------
	public function data($data=array()){
		if(!empty($data)){
			// data
			self::$data = $data;
			
			// keys
			$keys = array_keys($data['0']);
			self::$keys = $keys;
			self::$labels = $keys;
		}
		return self::$data;
	}
	
	// Title (in the document - optional)
	// ------------------------------------------
	public function title($title=''){
		if(!empty($title)) self::$title = $title;
		return self::$title;
	}
	
	// Keys
	// ------------------------------------------
	public function keys($keys = array()){
		if(!empty($keys)) self::$keys = $keys;
		return self::$keys;
	}
	
	// Delete a key
	// ------------------------------------------
	public function deleteKey($key){
		self::deleteKeys($key);
	}
	
	// Delete keys
	// ------------------------------------------
	public function deleteKeys(){
		// get keys
		$keys = func_get_args();
		
		// delete each key
		foreach($keys as $key){
			$i = array_search($key, self::$keys);
			if($i>=0){
				if(isset(self::$keys[$i])) unset(self::$keys[$i]);
				if(isset(self::$labels[$i])) unset(self::$labels[$i]);
			}			
		}
		self::$keys = array_values(self::$keys);
		self::$labels = array_values(self::$labels);
	}
	
	// Labels
	// ------------------------------------------
	public function labels($labels = array()){
		if(!empty($labels)) self::$labels = $labels;
		return self::$labels;
	}
	
	// Set label
	// ------------------------------------------
	public function setLabel($key, $label){
		$i = array_search($key, self::$keys);
		if(isset(self::$labels[$i])) self::$labels[$i] = $label;
	}
	
	// Export
	// ------------------------------------------	
	public function export(){
		$rowNr = 0;
		$data = self::data();
		$keys = self::keys();
		$labels = self::labels();
		$sData = count($data);
		$sKeys = count($keys);
		
		self::setDownloadHeader(self::filename().self::EXTENSION);
		
		// set xsl doc
		self::xlsBOF();
		
		// Make a top line on your excel sheet at line 1 (starting at 0).
		// The first number is the row number and the second number is the column, both are start at '0'
		if(isset(self::$title)){
			self::xlsWriteLabel($rowNr, 0, self::$title);
			$rowNr+=2;
		}

		// Make column labels. (at line 3)
		for($i=0; $i<$sKeys; $i+=1){
			self::xlsWriteLabel($rowNr, $i, $labels[$i]);
		}
		$rowNr+=1;
		
		// Put data records
		foreach($data as $row){
			for($i=0;$i<$sKeys;$i+=1){
				self::xlsWriteLabel($rowNr, $i, $row[$keys[$i]]);
			}
			$rowNr+=1;
		}
		self::xlsEOF();
		exit();
	}

	private function xlsBOF() {
		echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
		return;
	}
	private function xlsEOF() {
		echo pack("ss", 0x0A, 0x00);
		return;
	}
	private function xlsWriteNumber($Row, $Col, $Value) {
		echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
		echo pack("d", $Value);
		return;
	}
	private function xlsWriteLabel($Row, $Col, $Value ) {
		$L = strlen($Value);
		echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
		echo $Value;
		return;
	}
}
?>