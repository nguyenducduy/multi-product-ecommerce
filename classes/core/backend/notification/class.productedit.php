<?php

Class Core_Backend_Notification_ProductEdit extends Core_Backend_Notification
{
	public $pid = 0;
	public $editsection = '';
	
	public function __construct()
	{
		parent::__construct(); 
		$this->type = parent::TYPE_PRODUCT_EDIT; 
	}
	
	public function addData()
	{
		$this->data = array();
		$this->data['pid'] = $this->pid;
		$this->data['editsection'] = $this->editsection;
		
		return parent::addData();
	}

	/**
	* Add nhieu record 1 luc, su dung cu phap 
	* 
	* @param array $receiverList: danh sach ID cua nhung nguoi se nhan duoc notification
	*/
	public function addDataToMany($receiverList)
	{
		$this->data = array();
		$this->data['pid'] = $this->pid;
		$this->data['editsection'] = $this->editsection;
		
		return parent::addDataToMany($receiverList);
	}
	
	public function getIdHash()
	{
		return  $this->type . '-' . $this->pid . '.' . $this->editsection . $this->datecreated;              
	}
	
	public function showDetail($display = false)
	{
		global $registry;
		
		$this->pid = (int)$this->data['pid'];
		$this->editsection = (string)$this->data['editsection'];

		//Get product detail
		$productName = '';
		$productEditUrl = '';
                $productCategory = '';

		if($this->pid > 0)
		{
			$myProduct = new Core_Product($this->pid, true);
			$productName = $myProduct->name;
                        
                        $productCategoryID = $myProduct->pcid;
                        
                        $myProductCategory = new Core_Productcategory($productCategoryID);
                        $productCategory = $myProductCategory->name;
                        
			if($this->editsection != '')
			{
				$productName .= '('.$this->editsection.')';
			}

			$productEditUrl = $registry->conf['rooturl_cms'] . 'product/index/id/' . $myProduct->id;


		}
		else
		{
			$productName = 'Name not found';
			$productEditUrl = $registry->conf['rooturl_cms'] . 'product/index';
		}
		
		
		
		
		$out = '<a class="notifyitem" href="'.$productEditUrl.'"><strong>'.$this->actor->fullname.'</strong> Cập nhật SP " '.$productCategory.' - '.$productName.' "</a>';
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
		
}

