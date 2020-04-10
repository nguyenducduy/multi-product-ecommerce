<?php

Class Core_BadWordChecker extends Core_Object
{
	//neu detect qua so luong nay thi se enable la co van de voi noi dung
	public $minDetected = 1;
	public  $badwords = array('cặc', 'cặt', 'lồn', 'đụ ', 'dâm', 'đéo', 'chó má', 'chết tiệt', 'đĩ', 'cức', 'đái', 'địt', 'ỉa', 'vl', 'vcl', 'dm', 'vcl', 'dkm', 'bẹn', 'vú', 'đít',
		
		'việt minh', 'việt cộng', 'phản động', 'chính phủ', 'chính quyền', 'cứu quốc', 'vệ quốc', 'lật đổ', 'ngụy', 'bán nước', 'tham tàn',);
	public $replaceToCharacter = '*';
	public $ignoreClean = 0;
	
	public function isCleanString($inputArray = array())
	{
		mb_language('uni');
		mb_internal_encoding('UTF-8');
		
		$detected = 0;
		for($i = 0; $i < count($this->badwords); $i++)
		{
			$word = $this->badwords[$i];
			for($j = 0; $j < count($inputArray); $j++)
			{
				if(mb_strpos($inputArray[$j], $this->badwords[$i]) !== false)
					$detected++;
				
			}
		}
		
		if($detected > $this->minDetected)
			return false;
		else
			return true;
	}
	
	/*
	public function cleanString($str = '')
	{
		if($this->ignoreClean == 1)
			return $str;
			
		for($i = 0; $i < count($this->badwords); $i++)
		{
			$hideword = str_pad('', mb_strlen($this->badwords[$i]), $this->replaceToCharacter);
			//$str = str_ireplace($this->badwords[$i], $hideword, $str);
			$str = Helper::mb_str_ireplace($this->badwords[$i], $hideword, $str);
		}
		
		return $str;
	} 
	*/ 
	
	public function cleanString($str = '')
	{
		if($this->ignoreClean == 1)
			return $str;
			
		mb_language('uni');
		mb_internal_encoding('UTF-8');
			
		for($i = 0; $i < count($this->badwords); $i++)
		{
			$hideword = str_pad('', mb_strlen($this->badwords[$i]), $this->replaceToCharacter);
			//$str = str_ireplace($this->badwords[$i], $hideword, $str);
			$str = Helper::mb_str_ireplace($this->badwords[$i], $hideword, $str);
		}
		
		return $str;
	}  
	 
	
}


