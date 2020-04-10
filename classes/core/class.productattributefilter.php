<?php

/**
 * core/class.productattributefilter.php
 *
 * File contains the class used for ProductAttributeFilter Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProductAttributeFilter extends Core_Object
{
	const LEFT_POSITION = 1;
	const CENTER_POSITION = 2;
	const ALL_POSITION = 3;

	const TYPE_EXACT = 5;
	const TYPE_LIKE = 10;
	const TYPE_WEIGHT = 15;
    const TYPE_PRICE = 20;

	public $pcid = 0;
	public $paid = 0;
	public $paname = "";
	public $panameseo = "";
	public $id = 0;
	public $display = "";
	public $value = "";
	public $position = 0;
	public $displayorder = 0;
	public $displayreport = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $type = array();
	public $likevalue = array();
	public $weightfrom = array();
	public $weightto = array();
	public $unit = array();
	public $valueseo ="";
	public $likevalueseo ="";
	public $filtername = array();
	public $exactfilter  = array();
    public $pricename = array();
    public $pricefrom = array();
    public $priceto = array();

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
		$this->datecreated = time();


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_attribute_filter (
					pc_id,
					pa_id,
					pa_name,
					pa_nameseo,
					paf_display,
					paf_value,
					paf_position,
					paf_displayorder,
					paf_displayreport,
					paf_datecreated,
					paf_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->pcid,
					(int)$this->paid,
					(string)$this->paname,
					Helper::codau2khongdau($this->paname,true,true),
					(string)$this->display,
					(string)$this->value,
					(int)$this->position,
					(int)$this->displayorder,
					(int)$this->displayreport,
					(int)$this->datecreated,
					(int)$this->datemodified
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
		$this->datemodified = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_attribute_filter
				SET pc_id = ?,
					pa_id = ?,
					pa_name = ?,
					pa_nameseo = ?,
					paf_display = ?,
					paf_value = ?,
					paf_position = ?,
					paf_displayorder = ?,
					paf_displayreport = ?,
					paf_datecreated = ?,
					paf_datemodified = ?
				WHERE paf_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->pcid,
					(int)$this->paid,
					(string)$this->paname,
					(string)$this->panameseo,
					(string)$this->display,
					(string)$this->value,
					(int)$this->position,
					(int)$this->displayorder,
					(int)$this->displayreport,
					(int)$this->datecreated,
					(int)$this->datemodified,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_attribute_filter paf
				WHERE paf.paf_id = ?';
		$row                 = $this->db->query($sql, array($id))->fetch();

		$this->pcid          = $row['pc_id'];
		$this->paid          = $row['pa_id'];
		$this->paname        = $row['pa_name'];
		$this->panameseo     = $row['pa_nameseo'];
		$this->id            = $row['paf_id'];
		$this->display       = $row['paf_display'];
		$this->value         = $row['paf_value'];
		$this->position      = $row['paf_position'];
		$this->displayorder  = $row['paf_displayorder'];
		$this->displayreport = $row['paf_displayreport'];
		$this->datecreated   = $row['paf_datecreated'];
		$this->datemodified  = $row['paf_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_attribute_filter
				WHERE paf_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

	public static function deleteFilterByCategory($catId)
	{
		global $db;

		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_attribute_filter
				WHERE pc_id = ?';
		$rowCount = $db->query($sql, array($catId))->rowCount();

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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product_attribute_filter paf';

		if($where != '')
			$sql .= ' WHERE ' . $where;

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_attribute_filter paf';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myProductAttributeFilter                = new Core_ProductAttributeFilter();

			$myProductAttributeFilter->pcid          = $row['pc_id'];
			$myProductAttributeFilter->paid          = $row['pa_id'];
			$myProductAttributeFilter->paname        = $row['pa_name'];
			$myProductAttributeFilter->panameseo     = $row['pa_nameseo'];
			$myProductAttributeFilter->id            = $row['paf_id'];
			$myProductAttributeFilter->display       = $row['paf_display'];
			$myProductAttributeFilter->value         = $row['paf_value'];
			$myProductAttributeFilter->position      = $row['paf_position'];
			$myProductAttributeFilter->displayorder  = $row['paf_displayorder'];
			$myProductAttributeFilter->displayreport = $row['paf_displayreport'];
			$myProductAttributeFilter->datecreated   = $row['paf_datecreated'];
			$myProductAttributeFilter->datemodified  = $row['paf_datemodified'];


            $outputList[] = $myProductAttributeFilter;
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
	public static function getProductAttributeFilters($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpcid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'paf.pc_id = '.(int)$formData['fpcid'].' ';

		if(isset($formData['fpcidarr']) && count($formData['fpcidarr']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'paf.pc_id IN ('.implode(',', $formData['fpcidarr']).') ';

		if(isset($formData['fpaid']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'paf.pa_id = '.(int)$formData['fpaid'].' ';

        if(isset($formData['fpaidthan']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'paf.pa_id > 0 ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'paf.paf_id = '.(int)$formData['fid'].' ';

		if($formData['fdisplay'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'paf.paf_display = "'.Helper::unspecialtext((string)$formData['fdisplay']).'" ';

		if($formData['fvalue'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'paf.paf_value = "'.Helper::unspecialtext((string)$formData['fvalue']).'" ';

		if(isset($formData['fisdisplayreport']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'paf.paf_displayreport = 1';

        if($formData['fpanameseo'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'paf.pa_nameseo = "'.Helper::unspecialtext((string)$formData['fpanameseo']).'" ';

        // if(is_array($formData['fpanameseoarr']))
        // {
        // 	$whereString .= ($whereString != '' ? ' AND ' : '') . 'paf.pa_nameseo IN(';
        // 	for($i = 0 , $ilen = count($formData['fpanameseoarr']) ; $i < $ilen ; $i++)
        // 	{
        // 		if(strlen($formData['fpanameseoarr'][$i]) > 0)
        // 		{
        // 			if($i < $ilen-1)
        // 				$whereString .= '"'.$formData['fpanameseoarr'][$i].'" , ';
        // 			else
        // 				$whereString .= '"'.$formData['fpanameseoarr'][$i].'"';
        // 		}
        // 	}
        // 	$whereString .= ')';
        // }

        $numberOfSearchValueSEO = count($formData['fpanameseoarr']);
        if($numberOfSearchValueSEO > 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            $i = 0;
            foreach($formData['fpanameseoarr'] as $value)
            {
                if($i == $numberOfSearchValueSEO - 1)
                {
                    $whereString .= ' paf.pa_nameseo ="'.$value.'"';
                }
                else
                {
                    $whereString .= ' paf.pa_nameseo ="'.$value.'" OR ';
                }
                $i++;
            }
            $whereString .= ')';
        }

		if($formData['fposition'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'paf.paf_position = '.(int)$formData['fposition'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'display')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'paf.paf_display LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'value')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'paf.paf_value LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (paf.paf_display LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (paf.paf_value LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'paf_id ' . $sorttype;
		elseif($sortby == 'display')
			$orderString = 'paf_display ' . $sorttype;
		elseif($sortby == 'value')
			$orderString = 'paf_value ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'paf_displayorder ' . $sorttype;
		else
			$orderString = 'paf_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getPositionList()
	{
		global $registry;

		$output = array();

		$output[self::LEFT_POSITION] = 'Bên Trái';
		$output[self::CENTER_POSITION] = 'Ở Giữa';
		$output[self::ALL_POSITION] = 'Tất cả';

		return $output;
	}

	public function getPositionName()
	{
		$name = '';

		switch($this->position)
		{
			case self::LEFT_POSITION : $name = $this->registry->lang['controller']['labelLeftPosition']; break;
			case self::CENTER_POSITION: $name = $this->registry->lang['controller']['labelCenterPosition']; break;
			case self::ALL_POSITION: $name = $this->registry->lang['controller']['labelAllPosition']; break;
		}

		return $name;
	}

	public function checkPositionName($name)
	{
		$name = strtolower($name);

		if($this->position == self::LEFT_POSITION && $name == 'left' || $this->position == self::CENTER_POSITION && $name == 'center' || $this->position == self::ALL_POSITION && $name == 'all')
			return true;
		else
			return false;
	}

	public function getTypeList()
	{
		$outputList = array();

		$outputList[TYPE_EXACT] = 'Chính xác';
		$outputList[TYPE_LIKE] = 'Gần đúng';
		$outputList[TYPE_WEIGHT] = 'Trọng số';

		return $outputList;
	}


    /**
     * [getDataRow description]
     * @return [type] [description]
     */
    public function getDataRow()
    {
        $rows = array();

        if(strlen($this->value) > 0)
        {
            $rows = explode('###' , $this->value);
        }

        return $rows;
    }

    public static function getFilterReport($pcid)
    {
    	global $db;
    	$outputList = array();

    	$sql = 'SELECT pa_id , pa_name FROM ' . TABLE_PREFIX . 'product_attribute_filter WHERE paf_displayreport = 1 AND pc_id = ?';
    	$stmt = $db->query($sql , array($pcid));

    	while ( $row = $stmt->fetch())
    	{
    		$outputList[] = $row;
    	}

    	return $outputList;
    }

    /**
     * [getAtrributefilterNameSeos description]
     * @param  [type]  $pcid             [description]
     * @param  boolean $getprice         [description]
     * @param  [type]  $getreportdisplay [description]
     * @return [type]                    [description]
     */
    public static function getAtrributefilterId($pcid , $getreportdisplay = true)
    {
    	global $db;

    	$outputList = array();
    	if($pcid > 0)
    	{
    		$sql = 'SELECT pa_id , pa_name FROM ' . TABLE_PREFIX . 'product_attribute_filter WHERE pc_id = ? AND pa_id > 0';

    		if($getreportdisplay)
    			$sql .= ' AND paf_displayreport = 1';
    		$stmt = $db->query($sql , array($pcid));

    		while ($row = $stmt->fetch())
    		{
    			$outputList[] = $row;
    		}
    	}

    	return $outputList;
    }

    public static function getFilterOfCategoryFromCache($pcid , $displayreport = false)
    {
    	global $conf;
        $outputList = array();
    	$myCacher = new Cacher('filterlist' , Cacher::STORAGE_REDIS, $conf['redis'][1]);
    	$data = $myCacher->get();

    	if($data != false)
    	{
    		$attributefilterlist = json_decode($data , true);
    		$outputList = $attributefilterlist[$pcid];

	    	if($displayreport && count($outputList) > 0)
	    	{
	    		$datalist = $outputList;
	    		$outputList = array();
	    		foreach ($datalist as $attrslug => $dataarr)
	    		{
	    			if($dataarr['displayreport'] == 1)
	    			{
	    				$outputList[$attrslug] = $dataarr;
	    			}
	    		}
	    	}
    	}

    	return $outputList;
    }

	public static function getProductByPriceSegmentFromCache($catid = 0 , $segslugname = '' , $getall = false)
	{
	  	global $conf;
        $result = array();
		//$myCacher = new Cacher('pseglist' , Cacher::STORAGE_MEMCACHED , 86400 * 2);
		$myCacher = new Cacher('pseglist' ,  Cacher::STORAGE_REDIS, $conf['redis'][1] );
		$data = $myCacher->get();
		if($data != false)
		{
			$segmentlist = json_decode($data , true);
			if($catid > 0 && strlen($segslugname) > 0)
			{
			  	$result = $segmentlist[$catid][$segslugname];
			}
			elseif($getall)
			{
			  	$result = $segmentlist;
			}
		}
		return $result;
	}

	public static function getProductByMainCharacterFromCache($catid = 0 , $mainslugname = '' , $getall = false)
	{
		global $conf;
        $result = array();
		//$myCacher = new Cacher('pseglist' , Cacher::STORAGE_MEMCACHED , 86400 * 2);
		$myCacher = new Cacher('pcattrlist' , Cacher::STORAGE_REDIS, $conf['redis'][1] );
		$data = $myCacher->get();
		if($data != false)
		{
			$maincharacterlist = json_decode($data , true);
			if($catid > 0 && strlen($mainslugname) > 0)
			{
			  	$result = $maincharacterlist[$catid][$mainslugname];
			}
			elseif($getall)
			{
			  	$result = $maincharacterlist;
			}
		}
		return $result;
	}
}