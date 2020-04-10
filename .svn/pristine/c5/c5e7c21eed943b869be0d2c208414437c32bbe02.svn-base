<?php

/**
* Author: Vo Duy Tuan <tuanmaster2002@yahoo.com>
* Date: May 1st, 2011
* Using: //test
	$myRecommendPriorityQueue = new SizePriorityQueue(11);
	$myRecommendPriorityQueue->insert(5, 20);
	$myRecommendPriorityQueue->insert(1, 30);
	$myRecommendPriorityQueue->insert(3, 25);
	$myRecommendPriorityQueue->insert(7, 25);
	
	$myRecommendPriorityQueue->insert(9, 7);
	$myRecommendPriorityQueue->insert(5, 10);
	$myRecommendPriorityQueue->insert(19, 43);
	$myRecommendPriorityQueue->insert(39, 457);
	$myRecommendPriorityQueue->insert(2, 317);
	$myRecommendPriorityQueue->insert(23, 21);
	
	$myRecommendPriorityQueue->insert(19, 10);
	
	$myRecommendPriorityQueue->getAssocData();
*/
	Class SizePriorityQueue
	{
		private $count = 0;
		private $size = 0;
		private $aValue = array();	//danh sach gia tri da duoc sort theo thu tu giam dan priority khi them vao
		private $aPriority = array();	//mang assoc co cung index voi $aValue de biet priority cua 1 gia tri(phan tu)
		
		public function __construct($size)
		{
			$this->size = $size;
		}
		
		public function insert($value, $priority)
		{
			//echo '<hr>Count:'.  $this->count;
			//echo '<br>Current aValue: ' . implode(',', $this->aValue);
			//echo '<br>Current aPriority: ' . implode(',', $this->aPriority);
			if($this->count == 0)
			{
				$this->aValue[] = $value;
				$this->aPriority[] = $priority;
				$this->count++;
			}
			else
			{
				$insertPosition = -1;	//vi tri ma o do se them gia tri moi tuong ung voi priority
									//neu -1 thi se khong tim ra vi tri de them
				$isNewValue = false;
									
				//tien hanh tim vi tri(index) trong chuoi gia tri de them
				for($i = 0; $i < $this->count; $i++)
				{
					//echo '<br>' . $i . ':(' . $value . '=' . $priority . ') VS ('.$this->aPriority[$i].')';
					if($this->aPriority[$i] < $priority)
					{
						$insertPosition = $i;
						break;
					}
					
					//van con co hoi them
					if($this->count < $this->size)
					{
						$isNewValue = true;
					}
				}
				
				//them gia tri va priority vao dung index
				if($insertPosition >= 0)
				{
					//echo '<br>Insertposition:'.$insertPosition;
					array_splice($this->aValue, $insertPosition, 0, $value);
					array_splice($this->aPriority, $insertPosition, 0, $priority);
					$this->count++;
					
					//kiem tra xem da co du size chua
					//neu da co du size thi cat bo gia tri it priority nhat
					if($this->count > $this->size)
					{
						array_pop($this->aValue);
						array_pop($this->aPriority);
						$this->count--;
					}
				}
				elseif($isNewValue)
				{
					$this->aValue[] = $value; 
					$this->aPriority[] = $priority; 
					$this->count++;
				}
			}
			//var_dump($this->getPriority());
		}
		
		/**
		* Get data tu queue voi gia tri la key va priority la value
		* 
		*/
		public function getAssocData()
		{
			$output = array();
			for($i = 0; $i < $this->count; $i++)
			{
				$output[] = array($this->aValue[$i], $this->aPriority[$i]);
			}
			return $output;
		}
		
		public function getPriority()
		{
			return $this->aPriority;
		}
	}
	
	


