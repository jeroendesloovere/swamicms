<?php if(!defined('SWAMI')){die('External Access to File Denied');}
// price
// @author:				Jeroen Desloovere <info@jeroendesloovere.be>
// @date:					23-04-2011
// @description:	Prices are calculated including VAT
/**
 	$price = new price();
	$price->add(50);
	$price->delete($value);
	echo "Subtotal excl btw = ".$price->result(false);
	echo "+ BTW = ".$price->resultVAT();
	echo "Totaal incl btw = ".$price->result();
	
	echo price::exclBtw($inclBtw);
	echo price::inclBtw($exclBtw);
 **/
// @requires class Data
// ===========================================================================
class price
{
	// VAT = Value Added Taxes (you can override this)
	public static $VAT = 0.21;
	
	// Values after the comma allowed in result
	public static $valuesAfterComma = 2;
	public static $separator = ',';
	public static $thousandsSeparator = '';
	
	// Private total (VAT inclusive)
	private $total;

	// Construct
	// ---------------------------------------------------------------------------
	public function __construct($total = 0, $inclVAT = true)
	{
		$this->total = ($inclVAT) ? (float) $total : self::addVAT((float) $total);
		return $this;
	}
	
	// Add a (VAT inclusive or exclusive) value
	// ---------------------------------------------------------------------------
	public function add($number, $inclVAT = true)
	{
		$this->total += ($inclVAT) ? (float) $number : self::addVAT((float) $number);
		return $this;
	}
	
	// Delete a (VAT inclusive or exclusive) value
	// ---------------------------------------------------------------------------
	public function delete($number, $inclVAT = true)
	{
		$this->total -= ($inclVAT) ? (float) $number : self::addVAT((float) $number);
		return $this;
	}
	
	// Times the total (total * X)
	// ---------------------------------------------------------------------------
	public function times($number)
	{
		$this->total = $this->total * (float) $number;
		return $this;
	}
	
	// Divide the total (total / X)
	// ---------------------------------------------------------------------------
	public function divide($number)
	{
		$this->total = $this->total / (float) $number;
		return $this;
	}
	
	// Result total (VAT inclusive or exclusive)
	// ---------------------------------------------------------------------------
	public function result($inclVAT = true, $forDatabaseInput = false)
	{	
		// Get total
		$total = ($inclVAT) ? $this->total : self::deleteVAT($this->total, true);
		
		// Convert for database input (commas not allowed) or to output (commas allowed)
		return ($forDatabaseInput===true) ? $total : self::output($total);
	}
	
	// Result total VAT
	// ---------------------------------------------------------------------------
	public function resultVAT($forDatabaseInput = false)
	{	
		return self::getVAT($this->total, $forDatabaseInput);
	}
	
	// Add VAT to price
	// ---------------------------------------------------------------------------
	public static function addVAT($priceExclVAT, $forDatabaseInput = false)
	{
		$price = (phpversion() > '5.2.7') ? 
				round($priceExclVAT*(1+self::$VAT), self::$valuesAfterComma, PHP_ROUND_HALF_UP) : 
				round($priceExclVAT*(1+self::$VAT), self::$valuesAfterComma); // PHP_ROUND_HALF_UP doesn't exist on PHP < 5.2.7
		return ($forDatabaseInput===true) ? $price : self::output($price);
	}

	// Delete VAT from price
	// ---------------------------------------------------------------------------
	public static function deleteVAT($priceInclVAT, $forDatabaseInput = false)
	{
		$price = (phpversion() > '5.2.7') ? 
				round($priceInclVAT/(1+self::$VAT), self::$valuesAfterComma, PHP_ROUND_HALF_UP) : 
				round($priceInclVAT/(1+self::$VAT), self::$valuesAfterComma);
		return ($forDatabaseInput===true) ? $price : self::output($price);
	}
	
	// Get VAT from price
	// ---------------------------------------------------------------------------
	public static function getVAT($priceInclVAT, $forDatabaseInput = false)
	{
		$price = $priceInclVAT - self::deleteVAT($priceInclVAT, true);
		return ($forDatabaseInput===true) ? $price : self::output($price);
	}
	
	// Output price
	// ---------------------------------------------------------------------------
	public static function output($price)
	{
		return Data::toPrice((float) $price, self::$valuesAfterComma, self::$separator, self::$thousandsSeparator);
	}
	
	// Set Output
	// ---------------------------------------------------------------------------
	public static function setOutput($amount=false, $separator=false, $thousandsSeparator=false)
	{
		if($amount)								self::$valuesAfterComma = $amount;
		if($separator)						self::$separator = $separator;
		if($thousandsSeparator)		self::$thousandsSeparator = $thousandsSeparator;
	}
}