<?php
class Core_ProductEditInline extends Core_Object
{
	const TYPE_GROUPATTRIBUTE = 1;
	const TYPE_ATTRIBUTE = 3;
	const TYPE_REL = 5;

	public function __construct()
	{

	}

	public static function editInit($pcid, $vid = 0)
	{
		global $db;
        global $registry;
        $permission = false;
        //kiem tra xem user nay co trong nhom nguoi dc phep sua hay khong
        if(in_array($registry->me->groupid, $registry->setting['product']['allowEdit']))
        {
        	if(!$registry->me->isGroup('administrator') && !$registry->me->isGroup('developer'))
        	{
                //get full parentcategory from cache
                $parentcategorylist = Core_Productcategory::getFullParentProductCategoryId($myProduct->pcid);
                                
                //create suffix
                $suffix = 'pedit_' . $parentcategorylist[0];
                $permission = self::checkAccessTicket($suffix ,true);
        	}
        	else
        	{
				$permission = true;
        	}
        }

        return $permission;
	}

	/**
	 * cap nhat thong tin cua san pham dang text
	 * @param int pcid productcategoryid
	 * @param int pid productid
	 * @param array values array of value need update
	 * @return boolean result
	 */
	public static function updateData($pcid = 0, $pid = 0, $values = array())
	{
		global $db;

		$product = new Core_Product($pid);

		if($product->id > 0 && $product->pcid == $pcid)
		{			
			if(Core_ProductEditInline::editInit($pcid, $product->vid))
			{				
				if($pcid > 0 && $pid > 0 && count($values) > 0)
				{
					$sql = 'UPDATE ' . TABLE_PREFIX . 'product
							SET ';
					foreach($values as $colname=>$value)
					{
						$sql .= $colname . '="' . Helper::plaintext($value) . '",';
					}
	                $sql = substr($sql,0,-1);

					$sql .= ' WHERE p_id = ? AND pc_id = ?';//echo $sql;die();
					$stmt = $db->query($sql, array($pid, $pcid));

					return $stmt;
				}
			}
		}
	}

	/**
	* cap nhat thong tin cua produt attribute, group attribute , attribute value
	* @param int $pid productid
	* @param int $pcid productcategoryid
	* @param int $type TYPE_GROUPATTRIBUTE TYPE_ATTRIBUTE TYPE_REL
	* @param string $value value of attribute
	* @param int $id id of type
	* @return boolean $result
	*/
	public static function updateAttribute($pid = 0 , $pcid = 0, $type= 0, $value = '', $id)
	{
		global $db;
		$myProduct = new Core_Product($pid);
		$stmt = false;

		if($myProduct->id > 0 && $myProduct->pcid == $pcid)
		{
			if(Core_ProductEditInline::editInit($pcid, $myProduct->vid))
			{
				if($myProduct->id > 0 && $myProduct->pcid == $pcid)
				{
					$sql = '';
					switch($type)
					{
						case Core_ProductEditInline::TYPE_GROUPATTRIBUTE :
							$sql = 'UPDATE ' . TABLE_PREFIX . 'product_group_attribute
									SET pga_name = ?
									WHERE pga_id = ?';
							$stmt = $db->query($sql, array(Helper::plaintext($value), $id));
							break;
						case Core_ProductEditInline::TYPE_ATTRIBUTE :
							$sql = 'UPDATE ' . TABLE_PREFIX . 'product_attribute
									SET pa_name = ?
									WHERE pa_id = ?';
							$stmt = $db->query($sql, array(Helper::plaintext($value), $id));
							break;
						case Core_ProductEditInline::TYPE_REL :
							$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_product_attribute
									SET rpa_value = ?
									WHERE p_id = ? AND pa_id = ?';
							$stmt = $db->query($sql, array(Helper::plaintext($value), $pid, $id));
					}
				}
			}
		}

		return $stmt;
	}

    public static function editVideo($pid = 0, $pmid = 0, $value = '')
    {
        global $db;
        $myProduct = new Core_Product($pid);

        if($myProduct->id > 0)
        {
			if(Core_ProductEditInline::editInit($myProduct->pcid, $myProduct->vid))
			{
				$sql = 'UPDATE ' . TABLE_PREFIX . 'product_media
                    SET ';
		        $sql .= 'pm_moreurl="' . Helper::plaintext($value) . '"';

		        $sql .= ' WHERE p_id = ? AND pm_id = ?';

		        $stmt = $db->query($sql, array($pid, $pcid));
			}
        }

        return $stmt;
    }

    /**
	 * Check an Access Ticket when user visit a feature need to check authorization
	 */
	public static function checkAccessTicket($suffix = '', $isWildcardAction = false)
	{
		global $registry;
		$pass = false;

		$ticket = self::getAccessTicket($suffix, $isWildcardAction);
		
		if($registry->me->id > 0 && $registry->me->haveAccessTicket($ticket))
			$pass = true;
		
		return $pass;
	}
	

	/**
	 * Build Access Ticket for Authorization base on feature
	 */
	public static function getAccessTicket($suffix = '', $isWildcardAction = false)
	{
		if($isWildcardAction)
			$actionstring = '*';
		else
			$actionstring = $GLOBALS['action'];

		$ticket = $GLOBALS['controller_group'] . '_' . $GLOBALS['controller'] . '_' . $actionstring . '_' . $suffix;
		return $ticket;
	}
}
