<?php

/**
 * core/class.outputvoucherreturn.php
 *
 * File contains the class used for Outputvoucherreturn Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_Outputvoucherreturn extends Core_Backend_Object
{

	public $pbarcode = "";
	public $id = 0;
	public $saleorderid = "";
	public $saleorderdetailid = "";
	public $inputreturnid = "";
	public $outputvoucherid = "";
	public $outputvoucherdetailid = "";
	public $quantity = 0;
	public $imei = "";
	public $inputvoucherdetailid = "";
	public $inputtime = 0;
	public $inputvoucherid = "";
	public $isreturnwithfee = 0;
	public $price = "";
	public $returnfee = "";
	public $returnnote = "";
	public $returnreason = "";
	public $storemanageruser = 0;
	public $adjustprice = "";
	public $originalprice = "";
	public $totalvatlost = "";
	public $returnreasonid = 0;
	public $inputprice = "";
	public $ivdetailprice = "";
	public $iserror = 0;
	public $ovisdelete = 0;
	public $ovdetailisdelete = 0;
	public $sid = 0;
	public $inputtypeid = 0;
	public $orarowscn = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'outputvoucherreturn (
					p_barcode,
					ovr_saleorderid,
					ovr_saleorderdetailid,
					ovr_inputreturnid,
					ovr_outputvoucherid,
					ovr_outputvoucherdetailid,
					ovr_quantity,
					ovr_imei,
					ovr_inputvoucherdetailid,
					ovr_inputtime,
					ovr_inputvoucherid,
					ovr_isreturnwithfee,
					ovr_price,
					ovr_returnfee,
					ovr_returnnote,
					ovr_returnreason,
					ovr_storemanageruser,
					ovr_adjustprice,
					ovr_originalprice,
					ovr_totalvatlost,
					ovr_returnreasonid,
					ovr_inputprice,
					ovr_ivdetailprice,
					ovr_iserror,
					ovr_ovisdelete,
					ovr_ovdetailisdelete,
					s_id,
					ovr_inputtypeid,
					ovr_orarowscn
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(string)$this->pbarcode,
					(string)$this->saleorderid,
					(string)$this->saleorderdetailid,
					(string)$this->inputreturnid,
					(string)$this->outputvoucherid,
					(string)$this->outputvoucherdetailid,
					(int)$this->quantity,
					(string)$this->imei,
					(string)$this->inputvoucherdetailid,
					(int)$this->inputtime,
					(string)$this->inputvoucherid,
					(int)$this->isreturnwithfee,
					(string)$this->price,
					(string)$this->returnfee,
					(string)$this->returnnote,
					(string)$this->returnreason,
					(int)$this->storemanageruser,
					(string)$this->adjustprice,
					(string)$this->originalprice,
					(string)$this->totalvatlost,
					(int)$this->returnreasonid,
					(string)$this->inputprice,
					(string)$this->ivdetailprice,
					(int)$this->iserror,
					(int)$this->ovisdelete,
					(int)$this->ovdetailisdelete,
					(int)$this->sid,
					(int)$this->inputtypeid,
					(string)$this->orarowscn
					))->rowCount();

		$this->id = $this->db3->lastInsertId();
		return $this->id;
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{

		$sql = 'UPDATE ' . TABLE_PREFIX . 'outputvoucherreturn
				SET p_barcode = ?,
					ovr_saleorderid = ?,
					ovr_saleorderdetailid = ?,
					ovr_inputreturnid = ?,
					ovr_outputvoucherid = ?,
					ovr_outputvoucherdetailid = ?,
					ovr_quantity = ?,
					ovr_imei = ?,
					ovr_inputvoucherdetailid = ?,
					ovr_inputtime = ?,
					ovr_inputvoucherid = ?,
					ovr_isreturnwithfee = ?,
					ovr_price = ?,
					ovr_returnfee = ?,
					ovr_returnnote = ?,
					ovr_returnreason = ?,
					ovr_storemanageruser = ?,
					ovr_adjustprice = ?,
					ovr_originalprice = ?,
					ovr_totalvatlost = ?,
					ovr_returnreasonid = ?,
					ovr_inputprice = ?,
					ovr_ivdetailprice = ?,
					ovr_iserror = ?,
					ovr_ovisdelete = ?,
					ovr_ovdetailisdelete = ?,
					s_id = ?,
					ovr_inputtypeid = ?,
					ovr_orarowscn = ?
				WHERE ovr_id = ?';

		$stmt = $this->db3->query($sql, array(
					(string)$this->pbarcode,
					(string)$this->saleorderid,
					(string)$this->saleorderdetailid,
					(string)$this->inputreturnid,
					(string)$this->outputvoucherid,
					(string)$this->outputvoucherdetailid,
					(int)$this->quantity,
					(string)$this->imei,
					(string)$this->inputvoucherdetailid,
					(int)$this->inputtime,
					(string)$this->inputvoucherid,
					(int)$this->isreturnwithfee,
					(string)$this->price,
					(string)$this->returnfee,
					(string)$this->returnnote,
					(string)$this->returnreason,
					(int)$this->storemanageruser,
					(string)$this->adjustprice,
					(string)$this->originalprice,
					(string)$this->totalvatlost,
					(int)$this->returnreasonid,
					(string)$this->inputprice,
					(string)$this->ivdetailprice,
					(int)$this->iserror,
					(int)$this->ovisdelete,
					(int)$this->ovdetailisdelete,
					(int)$this->sid,
					(int)$this->inputtypeid,
					(string)$this->orarowscn,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'outputvoucherreturn o
				WHERE o.ovr_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->pbarcode = $row['p_barcode'];
		$this->id = $row['ovr_id'];
		$this->saleorderid = $row['ovr_saleorderid'];
		$this->saleorderdetailid = $row['ovr_saleorderdetailid'];
		$this->inputreturnid = $row['ovr_inputreturnid'];
		$this->outputvoucherid = $row['ovr_outputvoucherid'];
		$this->outputvoucherdetailid = $row['ovr_outputvoucherdetailid'];
		$this->quantity = $row['ovr_quantity'];
		$this->imei = $row['ovr_imei'];
		$this->inputvoucherdetailid = $row['ovr_inputvoucherdetailid'];
		$this->inputtime = $row['ovr_inputtime'];
		$this->inputvoucherid = $row['ovr_inputvoucherid'];
		$this->isreturnwithfee = $row['ovr_isreturnwithfee'];
		$this->price = $row['ovr_price'];
		$this->returnfee = $row['ovr_returnfee'];
		$this->returnnote = $row['ovr_returnnote'];
		$this->returnreason = $row['ovr_returnreason'];
		$this->storemanageruser = $row['ovr_storemanageruser'];
		$this->adjustprice = $row['ovr_adjustprice'];
		$this->originalprice = $row['ovr_originalprice'];
		$this->totalvatlost = $row['ovr_totalvatlost'];
		$this->returnreasonid = $row['ovr_returnreasonid'];
		$this->inputprice = $row['ovr_inputprice'];
		$this->ivdetailprice = $row['ovr_ivdetailprice'];
		$this->iserror = $row['ovr_iserror'];
		$this->ovisdelete = $row['ovr_ovisdelete'];
		$this->ovdetailisdelete = $row['ovr_ovdetailisdelete'];
		$this->sid = $row['s_id'];
		$this->inputtypeid = $row['ovr_inputtypeid'];
		$this->orarowscn = $row['ovr_orarowscn'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'outputvoucherreturn
				WHERE ovr_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where)
	{
		$db3 = self::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'outputvoucherreturn o';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		return $db3->query($sql)->fetchColumn(0);
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
		$db3 = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'outputvoucherreturn o';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myOutputvoucherreturn = new Core_Backend_Outputvoucherreturn();

			$myOutputvoucherreturn->pbarcode = $row['p_barcode'];
			$myOutputvoucherreturn->id = $row['ovr_id'];
			$myOutputvoucherreturn->saleorderid = $row['ovr_saleorderid'];
			$myOutputvoucherreturn->saleorderdetailid = $row['ovr_saleorderdetailid'];
			$myOutputvoucherreturn->inputreturnid = $row['ovr_inputreturnid'];
			$myOutputvoucherreturn->outputvoucherid = $row['ovr_outputvoucherid'];
			$myOutputvoucherreturn->outputvoucherdetailid = $row['ovr_outputvoucherdetailid'];
			$myOutputvoucherreturn->quantity = $row['ovr_quantity'];
			$myOutputvoucherreturn->imei = $row['ovr_imei'];
			$myOutputvoucherreturn->inputvoucherdetailid = $row['ovr_inputvoucherdetailid'];
			$myOutputvoucherreturn->inputtime = $row['ovr_inputtime'];
			$myOutputvoucherreturn->inputvoucherid = $row['ovr_inputvoucherid'];
			$myOutputvoucherreturn->isreturnwithfee = $row['ovr_isreturnwithfee'];
			$myOutputvoucherreturn->price = $row['ovr_price'];
			$myOutputvoucherreturn->returnfee = $row['ovr_returnfee'];
			$myOutputvoucherreturn->returnnote = $row['ovr_returnnote'];
			$myOutputvoucherreturn->returnreason = $row['ovr_returnreason'];
			$myOutputvoucherreturn->storemanageruser = $row['ovr_storemanageruser'];
			$myOutputvoucherreturn->adjustprice = $row['ovr_adjustprice'];
			$myOutputvoucherreturn->originalprice = $row['ovr_originalprice'];
			$myOutputvoucherreturn->totalvatlost = $row['ovr_totalvatlost'];
			$myOutputvoucherreturn->returnreasonid = $row['ovr_returnreasonid'];
			$myOutputvoucherreturn->inputprice = $row['ovr_inputprice'];
			$myOutputvoucherreturn->ivdetailprice = $row['ovr_ivdetailprice'];
			$myOutputvoucherreturn->iserror = $row['ovr_iserror'];
			$myOutputvoucherreturn->ovisdelete = $row['ovr_ovisdelete'];
			$myOutputvoucherreturn->ovdetailisdelete = $row['ovr_ovdetailisdelete'];
			$myOutputvoucherreturn->sid = $row['s_id'];
			$myOutputvoucherreturn->inputtypeid = $row['ovr_inputtypeid'];
			$myOutputvoucherreturn->orarowscn = $row['ovr_orarowscn'];


            $outputList[] = $myOutputvoucherreturn;
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
	public static function getOutputvoucherreturns($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_id = '.(int)$formData['fid'].' ';

		if($formData['forarowscn'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_orarowscn = "'.(string)$formData['forarowscn'].'" ';

		if($formData['fsaleorderid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_saleorderid = "'.Helper::unspecialtext((string)$formData['fsaleorderid']).'" ';

		if($formData['fsaleorderdetailid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_saleorderdetailid = "'.Helper::unspecialtext((string)$formData['fsaleorderdetailid']).'" ';

		if($formData['finputreturnid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_inputreturnid = "'.Helper::unspecialtext((string)$formData['finputreturnid']).'" ';

		if($formData['foutputvoucherid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_outputvoucherid = "'.Helper::unspecialtext((string)$formData['foutputvoucherid']).'" ';

		if($formData['foutputvoucherdetailid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_outputvoucherdetailid = "'.Helper::unspecialtext((string)$formData['foutputvoucherdetailid']).'" ';

		if($formData['fimei'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_imei = "'.Helper::unspecialtext((string)$formData['fimei']).'" ';

		if($formData['finputvoucherdetailid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_inputvoucherdetailid = "'.Helper::unspecialtext((string)$formData['finputvoucherdetailid']).'" ';

		if($formData['finputtime'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_inputtime = '.(int)$formData['finputtime'].' ';

		if($formData['finputvoucherid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_inputvoucherid = "'.Helper::unspecialtext((string)$formData['finputvoucherid']).'" ';

		if($formData['fiserror'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_iserror = '.(int)$formData['fiserror'].' ';

		if($formData['fovisdelete'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_ovisdelete = '.(int)$formData['fovisdelete'].' ';

		if($formData['fovdetailisdelete'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_ovdetailisdelete = '.(int)$formData['fovdetailisdelete'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'pbarcode')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.p_barcode LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'saleorderid')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_saleorderid LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'saleorderdetailid')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_saleorderdetailid LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'inputreturnid')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_inputreturnid LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'outputvoucherid')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_outputvoucherid LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'outputvoucherdetailid')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_outputvoucherdetailid LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'imei')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_imei LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'inputvoucherdetailid')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.ovr_inputvoucherdetailid LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (o.p_barcode LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (o.ovr_saleorderid LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (o.ovr_saleorderdetailid LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (o.ovr_inputreturnid LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (o.ovr_outputvoucherid LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (o.ovr_outputvoucherdetailid LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (o.ovr_imei LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (o.ovr_inputvoucherdetailid LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ovr_id ' . $sorttype;
		elseif($sortby == 'quantity')
			$orderString = 'ovr_quantity ' . $sorttype;
		else
			$orderString = 'ovr_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}