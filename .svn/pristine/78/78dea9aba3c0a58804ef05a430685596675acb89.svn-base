<?php

/**
 * Class dung de xu ly cac cong viec lien quan toi don vi cua price
 *	Don vi co ban-luu trong database: VND (Vietnam Dong)
 */
class Currency
{
	private $defaultCurrency = 'vnd';
	public  $currencyCode;
	
	//Bang ty le doi ngoai te
	protected $exchangeTable = array('vnd' => array('title' => 'Viet Nam Dong',
												   'exchange' => 1,
												   'prefix'	=> '',
												   'suffix'	=> ' VND',
												   'decimal' => 0,
												   'decSeperator' => '.',
												   'thousandSeperator' => ',',
										   ),		
									 'usd' => array('title' => 'US Dollar',
												   'exchange' => 18000,
												   'prefix'	=> '$',
												   'suffix'	=> '',
												   'decimal' => 2,
												   'decSeperator' => '.',
												   'thousandSeperator' => ','
										   ));
	
	function __construct($usdToVndExchange = 0)
	{
		//Find language to load
		$currency = '';
		if(isset($_SESSION['fcurrency']))
			$currency = strtolower($_SESSION['fcurrency']);
		elseif(isset($_COOKIE['fcurrency']))
			$currency = strtolower($_COOKIE['fcurrency']);
		else 
			$currency = $this->defaultCurrency;
			
			$this->currencyCode = $currency;
		
		if($usdToVndExchange > 0)
		{
			$this->exchangeTable['usd']['exchange'] = $usdToVndExchange;
		}
	}
	
	
	/**
	 * Ham in ra don vi tien can doi
	 * @param float $price : Tien - don vi VND
	 * @return string 
	 *
	 * @param unknown_type $vnd
	 */
	function formatPrice($price, $includePrefixAndSuffix = true, $calculateExchange = true)
	{
		$currency = $this->exchangeTable[$this->currencyCode];
		
		if($calculateExchange)
			$output = number_format(round($this->calculateExchangePrice($price),2), $currency['decimal'], $currency['decSeperator'], $currency['thousandSeperator']);
		else
			$output = number_format($price, $currency['decimal'], $currency['decSeperator'], $currency['thousandSeperator']);
		
		if($includePrefixAndSuffix)
		{
			$output = $currency['prefix'] . $output . $currency['suffix'];
		}
		return $output ;
	}
	
	function calculateExchangePrice($price)
	{
		
		$currency = $this->exchangeTable[$this->currencyCode];
		return round((float)$price/$currency['exchange'],2);
		
	}
	
	function convertCurrency($price, $toCurrency = "vnd", $fromCurrency="")
	{
		if(strlen($fromCurrency) == 0)
		{
			$fromCurrency = $this->currencyCode;
		}
		
		if($fromCurrency == $toCurrency)
			return $price;
		
		$sourceCurrency = $this->exchangeTable[$fromCurrency];
		$destCurrency =  $this->exchangeTable[$toCurrency];
		return round($price * $sourceCurrency['exchange'] / $destCurrency['exchange'],2);
	}
	
	function styling($number)
	{
		$currency = $this->exchangeTable[$this->currencyCode];	
		return $currency['prefix'] . $number . $currency['suffix'];
	}
	
	/**
	* Ham remove cac kytu khong can thiet trong chuoi price, de format thanh kieu float truoc khi xu ly insert,tinh toan
	* 
	* @param string $priceString
	*/
	public function refinePriceString($priceString = '')
	{
		$priceString = preg_replace('/[^0-9.]/','', $priceString);
		return $priceString;
	}
	
}


