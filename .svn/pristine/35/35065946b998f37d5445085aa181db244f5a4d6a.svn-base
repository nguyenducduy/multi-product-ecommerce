<?php
###########################################################
#
#	Class dung de luu thong tin shopping cart
#		thong tin chi bao gom ID va QUANTITY cua san pham
############################################################
class Core_ApcCart extends Core_Object
{
	protected $cartSession = '';
	protected $items = array();	//phan tu la {ID}_{ATTRIBUTE} de phan biet sp cung ID, nhung khac attribute
	protected $itemquantitys = array();
	protected $db;
	
	

	//constructor function
	public function __construct()
	{
		parent::__construct();    
		
		$isInit = false;	//flag to check first time of connect
		
		//tim xem da tao cart trong cookie chua
		if(isset($_COOKIE['cartSession']) && strlen($_COOKIE['cartSession'])>0)
		{
			$this->cartSession = $_COOKIE['cartSession'];
			
			$this->syncCartSession();
			
		}
		else 
		{
			//kiem tra session trong DB (if user not create cookie on remote host)
			$key = 'CART_' . Helper::getSessionId();
			$cart = apc_fetch($key);
			
			if($cart)
			{
				//tim thay cart
				$this->cartSession = $cart['sessionid'];
			}
			else
			{
				//ko tim thay o ca cookie va cart table
				//init new cart session for current session
				$this->initCart();
				
				//echo 'init cart';
				$isInit = true;
			}
		}
		
		//if not first time, retrieve cart info has been saved before
		if(!$isInit)
		{
			$this->retrieveFromSession();
		}
	}
	
	/**
	 * ham dung de dong bo giua cartsession trong cookie,SESSION va cart session trong db
	 * - dung trong truong hop close browser, nhung cookie van con, do do server se generate sessionid khac
	 */
	private function syncCartSession()
	{
		global $registry;
		
		$key = 'CART_' . $this->cartSession;
		$cart = apc_fetch($key);
		
		if($cart)
		{
			//update new sessionid for current cart
			$this->cartSession = Helper::getSessionId();
			setcookie('cartSession',$this->cartSession,time() + 30*24*3600,'/');
			$_SESSION['cartSession'] = $this->cartSession;
			
			$newkey = 'CART_' . $this->cartSession;
			$cart['userid'] = (int)$registry->me->id;
			$cart['sessionid'] = $this->cartSession;
			
			apc_store($newkey, $cart, time() + 30*24*3600);
		}
		else
		{
			//cart not found, generate new cart
			$this->initCart();
		}
	}
	
	private function initCart()
	{
		global $registry, $mobiledetect;
		
		$this->cartSession = Helper::getSessionId();
		setcookie('cartSession',$this->cartSession,time() + 30*24*3600, '/');
		$_SESSION['cartSession'] = $this->cartSession;
		
		if($registry->me->id > 0 || !$mobiledetect->isBot())
		{
			$key = 'CART_' . $this->cartSession;
			$cart = array(
				'userid' => (int)$registry->me->id,
				'sessionid' => $this->cartSession, 
				'detail' => array(),
				'datecreated' => time());
			apc_store($key, $cart, time() + 30 * 24 * 3600);
		}
		
	}
	
	/**
	 * Dung de lay du lieu trong database 
	 *
	 */
	public function retrieveFromSession()
	{
		$key = 'CART_' . $this->cartSession;
		$cart = apc_fetch($key);
		if($cart)
		{
			//parse du lieu ve sp
			$this->emptyCart();
			
			//Lay thong tin cart detail
			if(is_array($cart['detail']))
			{
				foreach($cart['detail'] as $cartdetail)
				{
					$pid = (int)$cartdetail['pid'];
					$quantity = (int)$cartdetail['quantity'];
					$name = Helper::plaintext($cartdetail['name']);
					$attribute = unserialize($cartdetail['attribute']);
					
					$this->addItem($pid, $quantity, $attribute);
				}
			}
		}
	}
	
	/**
	 * Luu thong tin hien tai cua cart vao database
	 *
	 */
	public function saveToSession()
	{
		$key = 'CART_' . $this->cartSession;
		$cart = apc_fetch($key);
		if($cart)
		{
			$items = $this->getContents();
			$detail = array();
			foreach($items as $item)
			{
				$detail[] = array(
					'pid' => $item->id,
					'quantity' => $item->quantity,
					'name' => '',
					'attribute' => serialize($item->options)
				);
			}
			$cart['detail'] = $detail;
			
			//Update to cart
			apc_store($key, $cart, time() + 30 * 24 * 3600);
		}
	}

	public function getContents()
	{
		$items = array();
		foreach($this->items as $tmp_item)
		{
			$item = new stdClass();
			$itemgroup = explode(':',$tmp_item,2);
			
			$item->id = $itemgroup['0'];
			
			//check if this product have option (can be promotion, attribute...)
			if(count($itemgroup) > 0)
				$item->options = unserialize($itemgroup['1']);

			
			$item->quantity = $this->itemquantitys[$tmp_item];
 			$items[] = $item;
		}
		return $items;
	}


	public function addItem($itemid, $quantity=1, $options = array())
	{ // adds an item to cart
		
		$itemgroup = $this->getItemGroup($itemid, $options);
			
		if(strlen($itemgroup) > 0)
		{
			if(!empty($this->itemquantitys[$itemgroup]) && $this->itemquantitys[$itemgroup] > 0)
			{ // the item is already in the cart..
			  // so we'll just increase the quantity
				$this->itemquantitys[$itemgroup] = $quantity + $this->itemquantitys[$itemgroup];
			} 
			else 
			{
				$this->items[]=$itemgroup;
				$this->itemquantitys[$itemgroup] = $quantity;
			}
		}
		
	}


	public function editItem($itemid, $quantity, $options = array())
	{ // changes an items quantity

		$itemgroup = $this->getItemGroup($itemid, $options);
		
		if($quantity < 1) 
			$this->delItem($itemgroup);
		else 
			$this->itemquantitys[$itemgroup] = $quantity;
	}


	public function getItemGroup($itemid, $options = array())
	{
		if(count($options) > 0)
			$itemgroup = $itemid . ':' . serialize($options);
		else
			$itemgroup = $itemid;
			
		return $itemgroup;
	}

	public function delItem($itemid, $options = array())
	{
		$itemgroup = $this->getItemGroup($itemid, $options);
		
		$ti = array();
		$this->itemquantitys[$itemgroup] = 0;
		foreach($this->items as $item)
		{
			$nitem = explode(':',$item,2);
            if(!empty($nitem[0]) && $nitem[0] != $itemgroup)
			{
				$ti[] = $item;
			}
		}
		$this->items = $ti;
	}


	public function emptyCart()
	{
		$this->items = array();
		$this->itemquantitys = array();
	}
	
	public function getCurrentQuantity($itemid, $options)
	{
		$itemgroup = $this->getItemGroup($itemid, $options);
		return $this->itemquantitys[$itemgroup];
	}

	public function itemCount()
	{
		return count($this->items);
	}
	
}

