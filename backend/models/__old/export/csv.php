<?php
class csv_model extends export_model
{
	const EXTENSION = '.csv';
	
	private static $separator = ';';
	
	public static $showColumnHeaders = true;
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
		$data = self::data();
		$keys = self::keys();
		$sKeys = count($keys);
		$filename = self::filename().self::EXTENSION;
		
		// set header
		self::setDownloadHeader($filename);
		header('Content-type: application/vnd.ms-excel');
		
		// Put data records
		foreach($data as $row){
			echo implode(self::$separator, $row);
			echo "\n";
		}
		
		/*
		// open stream
		$stream = fopen($filename, 'w');
		
		// output data
		if(self::$showColumnHeaders) {
	        fputcsv($stream, self::$labels);
	    }	
	    $nrows = 0;
	    foreach($data as $row){
	        fputcsv($stream, $row);
	        $nrows += 1;
	    }
	    
	    // close stream
	    fclose($stream);
	    return $nrows;*/
	}
}
?>