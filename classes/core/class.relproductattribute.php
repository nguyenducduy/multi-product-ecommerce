<?php

/**
 * core/class.relproductattribute.php
 *
 * File contains the class used for RelProductAttribute Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_RelProductAttribute extends Core_Object
{

	public $pid = 0;
	public $paid = 0;
	public $id = 0;
	public $value = "";
	public $weight = 0;
	public $valueseo = "";
	public $description = "";

    public function __construct($id = 0)
	{
		parent::__construct();

		if($id > 0)
			$this->getData($id);
	}

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'rel_product_attribute (
					p_id,
					pa_id,
					rpa_value,
					rpa_weight,
					rpa_description,
					rpa_valueseo
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->paid,
					(string)$this->value,
					(int)$this->weight,
					(string)$this->description,
					(string)Helper::codau2khongdau($this->value, true, true),
					))->rowCount();

		$this->id = $this->db->lastInsertId();
		return $this->id;
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{

		$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_product_attribute
				SET p_id = ?,
					pa_id = ?,
					rpa_value = ?,
					rpa_weight = ?,
					rpa_description = ?,
					rpa_valueseo = ?
				WHERE rpa_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->paid,
					(string)$this->value,
					(int)$this->weight,
					(string)$this->description,
					(string)Helper::codau2khongdau($this->value, true, true),
					(int)$this->id
					));

		if($stmt)
			return true;
		else
			return false;
	}

	/**
	 * Get the object data base on primary key
	 * @param int $id : the primary key value for searching record.
	 */
	public function getData($id)
	{
		$id = (int)$id;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_product_attribute rpa
				WHERE rpa.rpa_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pid = $row['p_id'];
		$this->paid = $row['pa_id'];
		$this->id = $row['rpa_id'];
		$this->value = $row['rpa_value'];
		$this->weight = $row['rpa_weight'];
		$this->description = $row['rpa_description'];
		$this->value = $row['rpa_valueseo'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'rel_product_attribute
				WHERE rpa_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where)
	{
		global $db;

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'rel_product_attribute rpa';

		if($where != '')
			$sql .= ' WHERE ' . $where;
		//echodebug($sql);
		return $db->query($sql)->fetchColumn(0);
	}

	/**
	 * Get the record in the table with paginating and filtering
	 *
	 * @param string $where the WHERE condition in SQL string
	 * @param string $order the ORDER in SQL string
	 * @param string $limit the LIMIT in SQL string
	 */
	public static function getList($where, $order, $limit = '')
	{
		global $db;

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_product_attribute rpa';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myRelProductAttribute = new Core_RelProductAttribute();

			$myRelProductAttribute->pid = $row['p_id'];
			$myRelProductAttribute->paid = $row['pa_id'];
			$myRelProductAttribute->id = $row['rpa_id'];
			$myRelProductAttribute->value = $row['rpa_value'];
			$myRelProductAttribute->weight = $row['rpa_weight'];
			$myRelProductAttribute->description = $row['rpa_description'];
			$myRelProductAttribute->valueseo = $row['rpa_valueseo'];


            $outputList[] = $myRelProductAttribute;
        }

        return $outputList;
    }

	/**
	 * Select the record, Interface with the outside (Controller Action)
	 *
	 * @param array $formData : filter array to build WHERE condition
	 * @param string $sortby : indicating the order of select
	 * @param string $sorttype : DESC or ASC
	 * @param string $limit: the limit string, offset for LIMIT in SQL string
	 * @param boolean $countOnly: flag to counting or return datalist
	 *
	 */
	public static function getRelProductAttributes($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fpaid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.pa_id = '.(int)$formData['fpaid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.rpa_id = '.(int)$formData['fid'].' ';

		if(isset($formData['fisprice']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.pa_id = 0 ';

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'value')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.rpa_value LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (rpa.rpa_value LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		if(is_array($formData['fpaidarr']))
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.pa_id IN( '.implode(',' , $formData['fpaidarr']).') ';
		}

		if(strlen($formData['fvalueseo']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.rpa_valueseo = '.(string)$formData['fvalueseo'].' ';

		if(is_array($formData['fvalueexactarr']))
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . '(';
			for($i = 0 , $ilen = count($formData['fvalueexactarr']); $i < $ilen ; $i++)
			{
				if($i == $ilen-1)
					$whereString .= 'rpa.rpa_valueseo = "'.$formData['fvalueexactarr'][$i].'"';
				else
					$whereString .= 'rpa.rpa_valueseo = "'.$formData['fvalueexactarr'][$i].'" OR ';
			}
			$whereString .= ')';
		}

		if(is_array($formData['fvaluelikeattr']))
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . '(';
			for($i = 0 , $ilen = count($formData['fvaluelikeattr']); $i < $ilen ; $i++)
			{
				if($i == $ilen-1)
					$whereString .= 'rpa.rpa_valueseo LIKE "%'.$formData['fvaluelikeattr'][$i].'%"';
				else
					$whereString .= 'rpa.rpa_valueseo = "%'.$formData['fvaluelikeattr'][$i].'%" OR ';
			}
			$whereString .= ')';
		}

		if($formData['fweightfrom'] > 0)
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.rpa_value >= ' . (float)$formData['fweightfrom'];
		}

		if($formData['fweightto'] > 0)
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.rpa_value <= ' . (float)$formData['fweightto'];
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'pid')
			$orderString = 'p_id ' . $sorttype;
		elseif($sortby == 'paid')
			$orderString = 'pa_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'rpa_id ' . $sorttype;
		elseif($sortby == 'value')
			$orderString = 'rpa_value ' . $sorttype;
		elseif($sortby == 'weight')
			$orderString = 'rpa_weight ' . $sorttype;
		else
			$orderString = 'rpa_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function deleteAttributeByProductId($pid = 0)
	{
		global $db;
		if($pid > 0)
		{
			$sql = 'DELETE FROM ' . TABLE_PREFIX . 'rel_product_attribute
					WHERE p_id = ?';
			$rowCount = $db->query($sql, array($pid))->rowCount();

			return $rowCount;
		}
	}

	public static function getRelProductAttributeByCategory($formData, $sortby, $sorttype, $groupBy = true, $limit='')
	{
		global $db;
		$whereString = '';
		$sql = 'SELECT DISTINCT(rpa.rpa_value) , rpa.p_id, rpa.pa_id, rpa_weight , rpa_description , rpa_valueseo FROM ' . TABLE_PREFIX . 'rel_product_attribute rpa';
		if($formData['fpcid'] > 0)
		{
			//$sql .= ' INNER JOIN ' . TABLE_PREFIX . 'product_attribute pa ON rpa.p_id = pa.pa_id';
			//$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pc_id = '.(int)$formData['fpcid'].' ';
		}

		if($formData['fpaid'] > 0)
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.pa_id = '.(int)$formData['fpaid'].' ';
		}

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'value')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.rpa_value LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (rpa.rpa_value LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		if(strlen($formData['fvalueseo']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.rpa_valueseo = '.(string)$formData['fvalueseo'].' ';


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'pid')
			$orderString = 'p_id ' . $sorttype;
		elseif($sortby == 'paid')
			$orderString = 'pa_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'rpa_id ' . $sorttype;
		elseif($sortby == 'weight')
			$orderString = 'rpa_weight ' . $sorttype;
		elseif($sortby == 'value')
			$orderString = 'rpa_value ' . $sorttype;

		else
			$orderString = 'rpa_id ' . $sorttype;

		$sql .= ' WHERE ' . $whereString;

		if($groupBy)
			$sql .= ' GROUP BY rpa.rpa_value';

		$sql .= ' ORDER BY ' . $orderString;
		/*if($limit != '')*/
			//$sql .= ' LIMIT 0,20';

		$outputList = array();
		$stmt = $db->query($sql);
		while ($row = $stmt->fetch())
		{
			$myRelProductAttribute        = new Core_RelProductAttribute();
			$myRelProductAttribute->id    = $row['rpa_id'];
			$myRelProductAttribute->pid   = $row['p_id'];
			$myRelProductAttribute->paid  = $row['pa_id'];
			$myRelProductAttribute->weight = $row['rpa_weight'];
			$myRelProductAttribute->description = $row['description'];
			$myRelProductAttribute->value = htmlspecialchars($row['rpa_value']);
			$myRelProductAttribute->valueseo = $row['rpa_valueseo'];

			$outputList[] = $myRelProductAttribute;
		}

		return $outputList;
	}

	public static function getProductIdByFilter($formData, $sortby, $sorttype)
	{
		global $db;
		$searchattr = array();
		$searchdata = array();
		$condition  = array();
		$whereString ='';
		//check pcid
		if($formData['fpcid'] > 0 && (count($formData['fvalue']) > 0 || (float)$formData['pricefrom'] || (float)$formData['priceto'] ))
		{
			$conditionfirst = '';
			if(isset($formData['fauto']))
			{
				$whereString = '';

				foreach($formData['fvalue'] as $attr => $value)
				{
					$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.pa_id = ' . (int)$attr . ' ';
					$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpa.rpa_valueseo="' . (string)$value[0] . '" ';
				}

				$sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'rel_product_attribute rpa ';

				if($whereString != '')
					$sql .= ' WHERE ' . $whereString;

	            $stmt = $db->query($sql);

				$outputList = array();

				while($row = $stmt->fetch())
				{
					$myProduct = new Core_Product($row['p_id']);
					if($myProduct->pcid == $formData['fpcid'])
					{
						$outputList[] = $row['p_id'];
					}
				}

				return $outputList;

			}
			elseif (isset($formData['fstat']))
			{
				$whereString = '';
				//$fullPathCat = (is_array($formData['fpcid'])?$formData['fpcid']: array($formData['fpcid']));//no la array()
				$listpricesegments = Core_ProductAttributeFilter::getProductAttributeFilters(array('fpcid' => $formData['fpcid'] , 'fpaid' => 0) , 'id' , 'ASC');
				//$listpricesegments = Core_ProductAttributeFilter::getProductAttributeFilters(array('fpcidarr' => $fullPathCat , 'fpaid' => 0) , 'id' , 'ASC');
				if(count($listpricesegments) > 0)
				{
					foreach($listpricesegments as $priceseg){
						$listpricesegment = $listpricesegments[0];

						$pricesegments = explode('###', $listpricesegment->value);
						//$pricesegments = explode('###', $priceseg->value);
						foreach($pricesegments as $rowdata)
						{
							$prices = explode('##', $rowdata);
							for($i = 0 , $ilen = count($formData['fvalue'])  ;$i < $ilen ; $i++)
							{
								if($formData['fvalue'][$i] == $prices[1])
								{
									$whereString .= '(';
									if($prices[3] > 0)
									{
										$whereString .= 'p.p_sellprice > ' . $prices[3] ;
									}

									if($prices[3] > 0 && $prices[4] > 0)
									{
										$whereString .= ' AND ';
									}

									if($prices[4] > 0)
									{
										$whereString .= 'p.p_sellprice < ' . $prices[4] ;
									}

									$whereString .= ')';

									if($i < $ilen-1)
									{
										$whereString .= ' OR ';
									}
								}
							}
						}
					}

					$sql = 'SELECT p.p_id FROM ' . TABLE_PREFIX . 'product p ';
					if($whereString != '')
					{
						if(count($fullPathCat) > 0)
						{
							$sql .= ' WHERE  ' . $whereString . ' AND pc_id IN('.implode(',' , $fullPathCat).') AND p_onsitestatus = ? AND p_instock > 0 AND p_sellprice > 0';
						}
					}

		            $stmt = $db->query($sql , array(Core_Product::OS_ERP));

					$outputList = array();

					while($row = $stmt->fetch())
					{
						$outputList[] = $row['p_id'];
					}


					return $outputList;
				}
			}
			else
			{
                $m = 0;
				foreach($formData['fvalue'] as $attrslug => $datavalue)
				{
					$j = 0;
					$ok = false;
	           		$checkprice = false;
                    $attributefilterdata = Core_ProductAttributeFilter::getProductAttributeFilters(array('fpcid' => $formData['fpcid'] , 'fpanameseo'=>$attrslug) , 'id' , 'ASC');

                    $dataattr =  $attributefilterdata[0];
					$info = explode('###', $dataattr->value);

					$i = 0;
					$j = 0;
					foreach ($info as $infodata)
					{
						$infoarr = explode('##', $infodata);
						if(in_array($infoarr[1], $datavalue))
						{
							if($infoarr[2] == Core_ProductAttributeFilter::TYPE_EXACT)
							{
								if($j > 0)
									$whereString .= ($whereString != '' ? ' OR ' : '') .'(rpa.pa_id = ' . $dataattr->paid . ' AND (' ;
								else
									$whereString .= '(rpa.pa_id = ' . $dataattr->paid . ' AND (' ;
								/*if($i == count($info) - 1)
								{
                                    $whereString .= 'rpa.rpa_value = "'. $infoarr[3] .'" )';
								}
								else
								{
									$whereString .= 'rpa.rpa_value = "'. $infoarr[3].'" )';
								}*/

                                $infosearch = explode('#' , $infoarr[3]);

                                $count = 0;
                                foreach($infosearch as $search)
                                {
                                    if($count == count($infosearch) - 1)
                                    {
                                        $whereString .= 'rpa.rpa_valueseo = "' . Helper::codau2khongdau($search , true , true) .'" )';
                                    }
                                    else
                                    {
                                        $whereString .= 'rpa.rpa_valueseo = "' . Helper::codau2khongdau($search , true , true) .'" OR ';
                                    }

                                    $count++;
                                }

								$whereString .= ') ';
								$j++;
							}
							elseif ($infoarr[2] == Core_ProductAttributeFilter::TYPE_LIKE)
							{
								if($j > 0)
									$whereString .= ($whereString != '' ? ' OR ' : '') .'(rpa.pa_id = ' . $dataattr->paid . ' AND (' ;
								else
									$whereString .= '(rpa.pa_id = ' . $dataattr->paid . ' AND (' ;

								/*if($i == count($info) - 1)
								{
									$whereString .= 'rpa.rpa_value LIKE "%'. $infoarr[3] .'%" )';
								}
								else
								{
									$whereString .= 'rpa.rpa_value LIKE "%'. $infoarr[3].'%" )';
								}*/

                                $infosearch = explode('#' , $infoarr[3]);
                                $count = 0;
                                foreach($infosearch as $search)
                                {
                                    if($count == count($infosearch) - 1)
                                    {
                                        $whereString .= 'rpa.rpa_valueseo LIKE "%' . Helper::codau2khongdau($search , true , true) .'%" )';
                                    }
                                    else
                                    {
                                        $whereString .= 'rpa.rpa_valueseo LIKE "%' . Helper::codau2khongdau($search , true , true) .'%" OR ';
                                    }

                                    $count++;
                                }

								$whereString .= ')';
								$j++;
							}
							elseif ($infoarr[2] == Core_ProductAttributeFilter::TYPE_WEIGHT)
							{
								if($j > 0)
									$whereString .= ($whereString != '' ? ' OR ' : '') .'(rpa.pa_id = ' . $dataattr->paid . ' AND (' ;
								else
									$whereString .= '(rpa.pa_id = ' . $dataattr->paid . ' AND (' ;

								if($i == count($info) - 1)
								{
									$whereString .= 'rpa.rpa_value >='. $infoarr[3] .' AND rpa.rpa_value <= ' . $infoarr[4] .')';
								}
								else
								{
									$whereString .= 'rpa.rpa_value >='. $infoarr[3] .' AND rpa.rpa_value <= ' . $infoarr[4] . ')';
								}
								$whereString .= ')';

								$j++;
							}
							elseif ($infoarr[2] == Core_ProductAttributeFilter::TYPE_PRICE)
							{
								$checkprice = true;

								if($j > 0)
									$whereString .= ($whereString != '' ? ' OR ' : '') .'(' ;
								else
									$whereString .= '(' ;

								if($i == count($info) - 1)
								{
									$whereString .=  'p.p_finalprice >'. ((float)$infoarr[3] > 0 ? '=' : '') .$infoarr[3] .(( (float)$infoarr[4] > 0) ? ' AND p.p_finalprice <= '.$infoarr[4].' ' : '');
								}
								else
								{
									$whereString .=  'p.p_finalprice >'.((float)$infoarr[3] > 0 ? '=' : '').$infoarr[3] .(( (float)$infoarr[4] > 0) ? ' AND p.p_finalprice <= '.$infoarr[4].' ' : '');
								}
								$whereString .= ')';
								$j++;
							}

						}
						$i++;
					}

	           		$whereString .= ' '; //$whereString .= ')';

	           		$m++;
	           		if($m == 1)
	           		{
	           			$conditionfirst = $attrslug;
	           			break;
	           		}
				}

				//search theo gia nguoi dung nhap vao
				if( (float)$formData['pricefrom'] > 0 || (float)$formData['priceto'] > 0 )
				{
					$checkprice = true;

					$whereString .=  'p.p_finalprice >'. ((float)$formData['pricefrom'] > 0 ? '=' : '') .$formData['pricefrom'] .(( (float)$formData['priceto'] > 0) ? ' AND p.p_finalprice <= '.$formData['priceto'].' ' : '');
				}

				if($checkprice)
				{
					$sql = 'SELECT p.p_id FROM ' . TABLE_PREFIX . 'product p WHERE ';
				}
				else
				{
					$sql = 'SELECT DISTINCT(rpa.p_id) FROM ' . TABLE_PREFIX . 'rel_product_attribute rpa INNER JOIN ' . TABLE_PREFIX . 'product p ON rpa.p_id = p.p_id WHERE ';
				}
				if(strlen(trim($whereString)) > 0)
					$sql .=  '('.$whereString . ') AND ';

				$productcategory = new Core_Productcategory($formData['fpcid'] , true);

				if($productcategory->parentid > 0)
				{
					$sql .= 'p.pc_id = ' . $productcategory->id;
				}
				else
				{
					//lay tat ca cac danh muc con cua danh muc hien tai
					$subcatelist = Core_Productcategory::getFullSubCategoryFromCache($productcategory->id , 3);
					$subcateidlist = array_keys($subcatelist);
					$subcateidlist[] = $productcategory->id;

					$sql .= 'p.pc_id IN (' . implode(',', $subcateidlist) . ')';

				}

                if($formData['fispromotion'] == 1)
                {
                    $sql .= ' AND p.p_promotionlist != ""';
                }

				$sql .=  ' AND p.p_onsitestatus > 0  AND p.p_status = ' . Core_Product::STATUS_ENABLE . ' AND p.p_customizetype=' . Core_Product::CUSTOMIZETYPE_MAIN;

				if(!$checkprice)
                {
                    $sql .= ' GROUP BY rpa.p_id ';

                    if($sortby == 'pid')
                    $orderString = 'p_id ' . $sorttype;
                    elseif($sortby == 'paid')
                        $orderString = 'pa_id ' . $sorttype;
                    elseif($sortby == 'id')
                        $orderString = 'rpa_id ' . $sorttype;
                    elseif($sortby == 'weight')
                        $orderString = 'rpa_weight ' . $sorttype;
                    else
                        $orderString = 'rpa_id ' . $sorttype;

                    $sql .= ' ORDER BY ' . $orderString;
                }

				$stmt = $db->query($sql);
//				echo $sql;
				$list = array();
				$outputList = array();
				while($row = $stmt->fetch())
				{
					$list[] = $row['p_id'];
				}

				if(count($list) > 0 && count($formData['fvalue']) > 1)
				{
					$m = 0;
					foreach ($list as $pid)
					{
						$have = true;
						$myProduct = new Core_Product($pid,true);
						if($myProduct->pcid != $formData['fpcid'])
						{
							$have = false;
						}
						else
						{
							$ok = false;
							foreach($formData['fvalue'] as $attrslug => $datavalue)
							{
								if($attrslug == $conditionfirst)
									continue;

								$i = 0;
								foreach ($datavalue as $data)
								{
									$attributefilterdata = self::getAttributeValue($formData['fpcid'] , $attrslug , $data);
									if($attributefilterdata[$data][2] == Core_ProductAttributeFilter::TYPE_EXACT)
									{
										$checker = Core_RelProductAttribute::getRelProductAttributes(array('fpid' => $pid , 'fpaid' => $attributefilterdata[$data]['pa_id'] , 'fvalueexactarr' => array($attributefilterdata[$data][1])) , 'id' , 'ASC' , '' , true);
										if($checker > 0)
										{
											$ok = true;
											break;
										}
										else
										{
											$ok = false;
											if($i == count($datavalue) - 1)
											{
												break;
											}
										}
									}
									elseif ($attributefilterdata[$data][2] == Core_ProductAttributeFilter::TYPE_LIKE)
									{										
										$checker = Core_RelProductAttribute::getRelProductAttributes(array('fpid' => $pid , 'fpaid' => $attributefilterdata[$data]['pa_id'] , 'fvaluelikeattr' => array($attributefilterdata[$data][1])) , 'id' , 'ASC' , '' , true);
										if($checker > 0)
										{
											$ok = true;
											break;
										}
										else
										{
											$ok = false;
											if($i == count($datavalue) - 1)
											{
												break;
											}
										}
									}
									elseif ($attributefilterdata[$data][2] == Core_ProductAttributeFilter::TYPE_WEIGHT)
									{
										$checker = Core_RelProductAttribute::getRelProductAttributes(array('fpid' => $pid , 'fpaid' => $attributefilterdata[$data]['pa_id'] , 'fweightfrom' => $attributefilterdata[$data][3] , 'fweightto' => $attributefilterdata[$data][4]) , 'id' , 'ASC' , '' , true);
										if($checker > 0)
										{
											$ok = true;
											break;
										}
										else
										{
											$ok = false;
											if($i == count($datavalue) - 1)
											{
												break;
											}
										}
									}
									elseif ($attributefilterdata[$data][2] == Core_ProductAttributeFilter::TYPE_PRICE)
									{
										$checker = Core_Product::getProducts(array('fid' => $pid , 'fsellpricefrom' => $attributefilterdata[$data][3] , 'fsellpriceto' => $attributefilterdata[$data][4]) , 'id' , 'ASC' , '' ,  true);
                                        if($checker > 0)
										{
											$ok = true;
											break;
										}
										else
										{
											$ok = false;
											if($i == count($datavalue) - 1)
											{
												break;
											}
										}
									}
									$i++;
								}
								if(!$ok)
									break;

							}//end of foreach

							//var_dump($ok);
							if($ok)
							{
								$outputList[] = $pid;
							}
						}
					}
					//echodebug($outputList,true);
					//die();

				}
				else
				{
					$outputList = $list;
				}
				if(count($outputList) > 0)
				{
					//sap xep gia cho san pham
					$resultlist = Core_Product::sortproductbyfilter($outputList);
				}
				else
					$resultlist = $outputList;

				return $resultlist;
			}
		}

	}

	public static function getAttributeValue($pcid , $attrslug , $data)
	{
		$outputList = array();
		$datasearch = Core_ProductAttributeFilter::getProductAttributeFilters(array('fpcid' => $pcid , 'fpanameseoarr' => array($attrslug)) , 'id' , 'ASC');
		$dataattr =  $datasearch[0];
		$info = explode('###', $dataattr->value);
		foreach ($info as $infodata)
		{
			$infoarr = explode('##', $infodata);
			if($infoarr[1] == $data)
			{
				$infoarr['pa_id'] = $dataattr->paid;
				$outputList[$infoarr[1]] = $infoarr;
			}
		}

		return $outputList;
	}

	public static function getProductIdByFilterFromCache($formData)
	{
		$outputList = array();
		$pcid = (int)$formData['fpcid'];
		if($pcid > 0)
		{
			//lay danh sach san pham cua danh muc hien tai tu cache
			$productlist = Core_Productcategory::getProductlistFromCache($pcid , $formData['fvidarr'], $formData['fbussinessstatuslist']);

			if (empty($formData['fvalue'])) return $productlist;

			//lay thong tin filter cua danh muc hien tai
			$filterlist = Core_ProductAttributeFilter::getFilterOfCategoryFromCache($pcid);
			if(count($productlist) > 0)
			{
				foreach ($productlist as $pid => $datavalue)
				{
					$ok = false;
					foreach ($formData['fvalue'] as $attrslug => $attrvalues)
					{
						$have = false;
						foreach ($attrvalues as $attrvalue)
						{
							$filterdatalist = $filterlist[$attrslug]['values'][$attrvalue];
							if(count($filterdatalist) > 0)
							{
								if($filterdatalist['type'] ==  Core_ProductAttributeFilter::TYPE_EXACT || $filterdatalist['type'] == Core_ProductAttributeFilter::TYPE_LIKE)
								{
									if(strpos($datavalue['attr'][$attrslug]['valueseo'], $filterdatalist['value']) !== false)
										$have = true;
									else
										$have = false;
									if ($have) break;
								}
								elseif ($filterdatalist['type'] == Core_ProductAttributeFilter::TYPE_WEIGHT)
								{
									if((float)$datavalue['attr'][$attrslug]['value'] >= (float)$filterdatalist['from'] && (float)$datavalue['attr'][$attrslug]['value'] <= (float)$filterdatalist['to'])
										$have = true;
									else
										$have = false;
									if ($have) break;
								}
								elseif ($filterdatalist['type'] == Core_ProductAttributeFilter::TYPE_PRICE)
								{
									if ($filterdatalist['from'] > 0 && $filterdatalist['to'] > $filterdatalist['from'])
									{
										if ($datavalue['sellprice'] >= $filterdatalist['from'] && $datavalue['sellprice'] <= $filterdatalist['to'])
										{
											$have = true;
										}
										else $have = false;
									}
									elseif ($filterdatalist['from'] > 0 && $filterdatalist['to'] <=0 )
									{
										if ($datavalue['sellprice'] >= $filterdatalist['from'])
										{
											$have = true;
										}
										else $have = false;
									}
									elseif ($filterdatalist['from'] <= 0 && $filterdatalist['to'] > 0)
									{
										if ($datavalue['sellprice'] >0 && $datavalue['sellprice'] <= $filterdatalist['to'])
										{
											$have = true;
										}
										else $have = false;
									}
									else $have = false;
									if ($have) break;
									/*if((float)$datavalue['sellprice'] >= (float)$filterdatalist['from'] && (float)$datavalue['sellprice'] <= (float)$filterdatalist['to'])
										$have = true;
									else
										$have = false;*/
								}
							}
						}

						$ok = $have;
						if($have) break;
					}
					if($ok)
					{
						$outputList[$pid] = $datavalue;
					}
				}
			}
		}

		return $outputList;
	}

	public static function getAttributeFFilterOfProductFromCache($pid = 0)
	{
		global $conf;
		$attributelist = array();
		if($pid > 0)
		{
			$myCacher = new Cacher('pa:list_' . $pid , Cacher::STORAGE_REDIS, $conf['redis'][1]);
			$data = $myCacher->get();

			if($data != false)
			{
				$datalist = explode('#', $data);
				if(count($datalist) > 0)
				{
					foreach ($datalist as $info)
					{
						$infoarr = explode(':', $info);
						if(count($infoarr) == 4)
							$attributelist[$infoarr[1]] = array('slug' => $infoarr[1] , 'value' => $infoarr[2] , 'valueseo' => $infoarr[3]);
						else
							$attributelist['gia'] = array('value' => $infoarr[1] , 'valueseo' => $infoarr[0]);
					}
				}
			}
		}

		return $attributelist;
	}

	public static function updateweightbyattribute($valueseo = '', $paid = 0, $weight=0)
	{
		global $db;

		if(strlen($valueseo) > 0 && $paid > 0)
		{
			$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_product_attribute
					SET rpa_weight = ?
					WHERE pa_id = ? AND rpa_value = ?';
			$stmt = $db->query($sql , array((int)$weight,
											(int)$paid,
											(string)$valueseo));

			if($stmt)
				return true;
			else
				return false;
		}
	}


}

