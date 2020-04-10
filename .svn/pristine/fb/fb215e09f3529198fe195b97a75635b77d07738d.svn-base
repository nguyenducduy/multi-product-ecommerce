<?php
###########################################################
#
#	Class dung de luu thong tin shopping cart
#		thong tin chi bao gom ID va QUANTITY cua san pham
############################################################
class Core_Cart extends Core_Object
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
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'cart
					WHERE c_sessionid = ?
					LIMIT 1';
			$cart = $this->db->query($sql, array(Helper::getSessionId()))->fetch();
			if($cart['c_id'] > 0)
			{
				//tim thay cart
				$this->cartSession = $cart['c_sessionid'];
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
		//check cookie existed on database
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'cart
				WHERE c_sessionid = ?
				LIMIT 1';
		$cart = $this->db->query($sql, array($this->cartSession))->fetch();
		if($cart['c_id'] > 0)
		{
			//update new sessionid for current cart
			$this->cartSession = Helper::getSessionId();
			setcookie('cartSession',$this->cartSession,time() + 30*24*3600,'/');
			$_SESSION['cartSession'] = $this->cartSession;

			$sql = 'UPDATE ' . TABLE_PREFIX . 'cart
					SET c_sessionid = ?
					WHERE c_id = ?
					LIMIT 1';
			$this->db->query($sql,array($this->cartSession, $cart['c_id']));

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
			//initialize cart in DB
			$sql = 'INSERT INTO ' . TABLE_PREFIX . 'cart(`c_sessionid`, `c_datecreated`)
					VALUES(?,?)';
			$this->db->query($sql, array($this->cartSession, time()));
		}

	}

	/**
	 * Dung de lay du lieu trong database
	 *
	 */
	public function retrieveFromSession()
	{
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'cart
				WHERE c_sessionid = ?
				LIMIT 1';
		$cart = $this->db->query($sql, array($this->cartSession))->fetch();
		if($cart['c_id'] > 0)
		{
			//parse du lieu ve sp
			$this->emptyCart();

			//truy van de lay cart detail
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'cart_detail
					WHERE c_id = ?';
			$rows = $this->db->query($sql, array($cart['c_id']))->fetchAll();
			foreach ($rows as $item)
			{
				$item['cd_quantity'] = (int)($item['cd_quantity']);
				if( $item['cd_quantity'] > 0)
				{
					$this->addItem($item['p_id'], $item['cd_quantity'], unserialize($item['cd_attribute']));
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
		//begin save
		$sql = 'SELECT c_id FROM ' . TABLE_PREFIX . 'cart
				WHERE c_sessionid = ?
				LIMIT 1';
		$cartid = $this->db->query($sql, array($this->cartSession))->fetchColumn(0);

		if($cartid > 0)
		{
			//clear old item from current cart
			$sql = 'DELETE FROM ' . TABLE_PREFIX . 'cart_detail
					WHERE c_id = ?';
			$this->db->query($sql, array($cartid));

			$items = $this->getContents();
			//insert new detail for current cart
			foreach ($items as $item)
			{
				$sql = 'INSERT INTO ' . TABLE_PREFIX . 'cart_detail(`c_id`, `p_id`, `cd_quantity`, `cd_attribute`)
						VALUES(?, ?, ?, ?)';
				$this->db->query($sql, array($cartid, $item->id, $item->quantity, serialize($item->options)));
			}
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
	{ // removes an item from cart
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
	} //end of del_item


	public function emptyCart()
	{ // empties / resets the cart
		$this->items = array();
		$this->itemquantitys = array();
	} // end of empty cart

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

