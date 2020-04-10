<?php

/**
 * core/class.installment.php
 *
 * File contains the class used for Installment Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Installment extends Core_Object
{
	const GENDER_MALE = 1;
    const GENDER_FEMALE = 3;
    const PAYATHOME_YES = 1;
    const PAYATHOME_NO = 3;
    const TYPE_SINHVIEN = 4;
    const TYPE_NGUOIDILAM = 1;
    public $pid = 0;
	public $uid = 0;
	public $id = 0;
    public $invoiceid = "";
	public $installmentcrm = "";
	public $pricesell = 0;
	public $pricemonthly = 0;
	public $gender = 0;
	public $fullname = "";
	public $phone = "";
	public $email = "";
	public $birthday = 0;
	public $personalid = 0;
	public $personaltype = 0;
	public $address = "";
	public $region = 0;
	public $regionresident = 0;
	public $installmentmonth = 0;
	public $segmentpercent = 0;
	public $payathome = 0;
	public $datecreate = 0;
	public $installmentcrmdate = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'installment (
                    p_id,
					u_id,
					i_invoiceid,
					i_pricesell,
					i_pricemonthly,
					i_gender,
					i_fullname,
					i_phone,
					i_email,
					i_birthday,
					i_personalid,
					i_personaltype,
					i_address,
					i_region,
					i_regionresident,
					i_installmentmonth,
					i_segmentpercent,
					i_payathome,
					i_datecreate,
					i_installmentcrmdate
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
                    (int)$this->pid,
					(int)$this->uid,
					(string)$this->invoiceid,
					(float)$this->pricesell,
					(float)$this->pricemonthly,
					(int)$this->gender,
					(string)$this->fullname,
					(string)$this->phone,
					(string)$this->email,
					(int)$this->birthday,
					(int)$this->personalid,
					(int)$this->personaltype,
					(string)$this->address,
					(int)$this->region,
					(int)$this->regionresident,
					(int)$this->installmentmonth,
					(int)$this->segmentpercent,
					(int)$this->payathome,
					(int)$this->datecreate,
					(int)$this->installmentcrmdate
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'installment
				SET p_id = ?,
                    i_invoiceid = ?,
					i_installmentcrm = ?,
					i_pricesell = ?,
					i_pricemonthly = ?,
					i_gender = ?,
					i_fullname = ?,
					i_phone = ?,
					i_email = ?,
					i_birthday = ?,
					i_personalid = ?,
					i_personaltype = ?,
					i_address = ?,
					i_region = ?,
					i_regionresident = ?,
					i_installmentmonth = ?,
					i_segmentpercent = ?,
					i_payathome = ?,
					i_datecreate = ?,
					i_installmentcrmdate = ?
				WHERE i_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->pid,
                    (string)$this->invoiceid,
					(int)$this->installmentcrm,
					(float)$this->pricesell,
					(float)$this->pricemonthly,
					(int)$this->gender,
					(string)$this->fullname,
					(string)$this->phone,
					(string)$this->email,
					(int)$this->birthday,
					(int)$this->personalid,
					(int)$this->personaltype,
					(string)$this->address,
					(int)$this->region,
					(int)$this->regionresident,
					(int)$this->installmentmonth,
					(int)$this->segmentpercent,
					(int)$this->payathome,
					(int)$this->datecreate,
					(int)$this->installmentcrmdate,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'installment i
				WHERE i.i_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pid = $row['p_id'];
		$this->id = $row['i_id'];
        $this->installmentcrm = $row['i_installmentcrm'];
		$this->invoiceid = $row['i_invoiceid'];
		$this->pricesell = $row['i_pricesell'];
		$this->pricemonthly = $row['i_pricemonthly'];
		$this->gender = $row['i_gender'];
		$this->fullname = $row['i_fullname'];
		$this->phone = $row['i_phone'];
		$this->email = $row['i_email'];
		$this->birthday = $row['i_birthday'];
		$this->personalid = $row['i_personalid'];
		$this->personaltype = $row['i_personaltype'];
		$this->address = $row['i_address'];
		$this->region = $row['i_region'];
		$this->regionresident = $row['i_regionresident'];
		$this->installmentmonth = $row['i_installmentmonth'];
		$this->segmentpercent = $row['i_segmentpercent'];
		$this->payathome = $row['i_payathome'];
		$this->datecreate = $row['i_datecreate'];
		$this->installmentcrmdate = $row['i_installmentcrmdate'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'installment
				WHERE i_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'installment i';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'installment i';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
        //if ($_GET['test']) echodebug($sql);
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myInstallment = new Core_Installment();

			$myInstallment->pid = $row['p_id'];
			$myInstallment->id = $row['i_id'];
            $myInstallment->installmentcrm = $row['i_installmentcrm'];
			$myInstallment->invoiceid = $row['i_invoiceid'];
			$myInstallment->pricesell = $row['i_pricesell'];
			$myInstallment->pricemonthly = $row['i_pricemonthly'];
			$myInstallment->gender = $row['i_gender'];
			$myInstallment->fullname = $row['i_fullname'];
			$myInstallment->phone = $row['i_phone'];
			$myInstallment->email = $row['i_email'];
			$myInstallment->birthday = $row['i_birthday'];
			$myInstallment->personalid = $row['i_personalid'];
			$myInstallment->personaltype = $row['i_personaltype'];
			$myInstallment->address = $row['i_address'];
			$myInstallment->region = $row['i_region'];
			$myInstallment->regionresident = $row['i_regionresident'];
			$myInstallment->installmentmonth = $row['i_installmentmonth'];
			$myInstallment->segmentpercent = $row['i_segmentpercent'];
			$myInstallment->payathome = $row['i_payathome'];
			$myInstallment->datecreate = $row['i_datecreate'];
			$myInstallment->installmentcrmdate = $row['i_installmentcrmdate'];


            $outputList[] = $myInstallment;
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
	public static function getInstallments($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.i_id = '.(int)$formData['fid'].' ';

		if($formData['finvoiceid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.i_invoiceid = "'.Helper::unspecialtext((string)$formData['finvoiceid']).'" ';

		if($formData['fphone'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.i_phone = "'.Helper::unspecialtext((string)$formData['fphone']).'" ';

		if($formData['femail'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.i_email = "'.Helper::unspecialtext((string)$formData['femail']).'" ';

		if($formData['fisorderidcrm'] ==1)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'i.i_installmentcrm= 0 ';

        if($formData['fstartdate'] > 0 && $formData['fenddate'] > 0 )
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'i.i_datecreate >= '.(int)$formData['fstartdate'].' AND i.i_datecreate <='.(int)$formData['fenddate'];


		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'invoiceid')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.i_invoiceid LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'phone')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.i_phone LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'email')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.i_email LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (i.i_invoiceid LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (i.i_phone LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (i.i_email LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'i_id ' . $sorttype;
		elseif($sortby == 'invoiceid')
			$orderString = 'i_invoiceid ' . $sorttype;
		else
			$orderString = 'i_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

    public function getInvoicedCode()
    {
        $code = Helper::alphaID($this->id, false, false, 'dminstmnt').Helper::RandomNumber(1000, 9999).'I';
        return $code;
    }

    public static function calcInstallment($price, $prepaid, $paytime, $pcid)
    {
        if(empty($price) && empty($prepaid) && empty($paytime) && empty($pcid)) return false;
        if($prepaid < 0.2) return false;
        if($price < 3000000) return false;
        if($pcid ==42 && $price < 3400000) return false;
        //42: dtdd, 44: notebote, 48 kythuat so (camera)
        $type = 2; //loai = 2 la tat ca nganh hang khac, loaij = 1 la 3 nganh hang 42,44,48
        $category = array(42, 44, 48);
        if(in_array($pcid, $category)) $type = 1;
        $installmentList = array();
        /* Cho 3 nganh hang: credit là  số tiền vay */
        //installmentlist: 1: de biet la nganh hang nao, 79: là credit nhỏ hơn 8triệu, 29: là DP (trả trước) nhỏ hơn 30%, 6,9,12,15: là tháng
        $installmentList[1][79][29][6] = 0.21485;
        $installmentList[1][79][29][9] = 0.15891;
        $installmentList[1][79][29][12] = 0.13178;
        $installmentList[1][79][29][15] = 0.11617;
        $installmentList[1][79][29][18] = 0.10633;
        //installmentlist: 1: de biet la nganh hang nao, 79: là credit nhỏ hơn 8triệu, 39: là DP (trả trước) lớn hơn 30% và nhỏ hơn 40%, 6,9,12,15: là tháng
        $installmentList[1][79][39][6] = 0.21319;
        $installmentList[1][79][39][9] = 0.15722;
        $installmentList[1][79][39][12] = 0.13003;
        $installmentList[1][79][39][15] = 0.11434;
        $installmentList[1][79][39][18] = 0.10441;
        //installmentlist: 1: de biet la nganh hang nao, 79: là credit nhỏ hơn 8triệu, 40: là DP (trả trước) lớn hơn =40% , 6,9,12,15: là tháng
        $installmentList[1][79][40][6] = 0.21044;
        $installmentList[1][79][40][9] = 0.15443;
        $installmentList[1][79][40][12] = 0.12713;
        $installmentList[1][79][40][15] = 0.11132;
        $installmentList[1][79][40][18] = 0.10125;

        //installmentlist: 1: de biet la nganh hang nao, 80: là credit lớn hơn =8triệu, 29: là DP (trả trước) nhỏ hơn 30%, 6,9,12,15: là tháng
        $installmentList[1][80][29][6] = 0.21874;
        $installmentList[1][80][29][9] = 0.16289;
        $installmentList[1][80][29][12] = 0.13592;
        $installmentList[1][80][29][15] = 0.12050;
        $installmentList[1][80][29][18] = 0.11086;
        //installmentlist: type: de biet la nganh hang nao, 80: là credit lớn hơn =8triệu, 39: là DP (trả trước) lớn hơn 30% và nhỏ hơn 40%, 6,9,12,15: là tháng
        $installmentList[1][80][39][6] = 0.21707;
        $installmentList[1][80][39][9] = 0.16118;
        $installmentList[1][80][39][12] = 0.13414;
        $installmentList[1][80][39][15] = 0.11864;
        $installmentList[1][80][39][18] = 0.10891;
        //installmentlist: 1: de biet la nganh hang nao, 80: là credit lớn hơn =8triệu, 40: là DP (trả trước) lớn hơn =40% , 6,9,12,15: là tháng
        $installmentList[1][80][40][6] = 0.21429;
        $installmentList[1][80][40][9] = 0.15835;
        $installmentList[1][80][40][12] = 0.13120;
        $installmentList[1][80][40][15] = 0.11556;
        $installmentList[1][80][40][18] = 0.10569;


        /*Cho nhung nganh hang khac*/
        //installmentlist: 2: de biet la nganh hang khac, 79: là credit nhỏ hơn 8triệu, 29: là DP (trả trước) nhỏ hơn 30%, 6,9,12,15: là tháng
        $installmentList[2][79][29][6] = 0.21209;
        $installmentList[2][79][29][9] = 0.15610;
        $installmentList[2][79][29][12] = 0.12886;
        $installmentList[2][79][29][15] = 0.11313;
        $installmentList[2][79][29][18] = 0.10314;
        //installmentlist: 2: de biet la nganh hang khac, 79: là credit nhỏ hơn 8triệu, 39: là DP (trả trước) lớn hơn 30% và nhỏ hơn 40%, 6,9,12,15: là tháng
        $installmentList[2][79][39][6] = 0.21044;
        $installmentList[2][79][39][9] = 0.15443;
        $installmentList[2][79][39][12] = 0.12713;
        $installmentList[2][79][39][15] = 0.11132;
        $installmentList[2][79][39][18] = 0.11132;
        //installmentlist: 2: de biet la nganh hang khac, 79: là credit nhỏ hơn 8triệu, 40: là DP (trả trước) lớn hơn =40% , 6,9,12,15: là tháng
        $installmentList[2][79][40][6] = 0.20770;
        $installmentList[2][79][40][9] = 0.15166;
        $installmentList[2][79][40][12] = 0.15166;
        $installmentList[2][79][40][15] = 0.10833;
        $installmentList[2][79][40][18] = 0.10833;

        //installmentlist: 2: de biet la nganh hang khac, 80: là credit lớn hơn =8triệu, 29: là DP (trả trước) nhỏ hơn 30%, 6,9,12,15: là tháng
        $installmentList[2][80][29][6] = 0.21595;
        $installmentList[2][80][29][9] = 0.21595;
        $installmentList[2][80][29][12] = 0.21595;
        $installmentList[2][80][29][15] = 0.11740;
        $installmentList[2][80][29][18] = 0.10761;
        //installmentlist: 2: de biet la nganh hang khac, 80: là credit lớn hơn =8triệu, 39: là DP (trả trước) lớn hơn 30% và nhỏ hơn 40%, 6,9,12,15: là tháng
        $installmentList[2][80][39][6] = 0.21429;
        $installmentList[2][80][39][9] = 0.15835;
        $installmentList[2][80][39][12] = 0.13120;
        $installmentList[2][80][39][15] = 0.11556;
        $installmentList[2][80][39][18] = 0.10569;
        //installmentlist: 2: de biet la nganh hang khac, 80: là credit lớn hơn =8triệu, 40: là DP (trả trước) lớn hơn =40% , 6,9,12,15: là tháng
        $installmentList[2][80][40][6] = 0.10569;
        $installmentList[2][80][40][9] = 0.10569;
        $installmentList[2][80][40][12] = 0.12828;
        $installmentList[2][80][40][15] = 0.11252;
        $installmentList[2][80][40][18] = 0.10251;

        //Tính cho ACS:
        $arrayACS = array();
        $arrayACS['nosupport'] = 1;//1 là hỗ trợ
        if($pcid == 42)
        {
            $arrayACS['monthly'] = ceil($price * (1 - $prepaid) * (1/$paytime + (2.6/100)));
        }
        else
        {
            $arrayACS['monthly'] = ceil($price * (1 - $prepaid) * (1/$paytime + (2.2/100)));
        }
        $arrayACS['totalprepaid'] = ceil($price * $prepaid);
        if($arrayACS['totalprepaid'] >= 3000000 || ($paytime > 12 && $pcid == 42)) {
            $arrayACS['nosupport'] = 0; //0 là ko là không hỗ trợ
        }

        //Tính cho PPF:
        $arrPPF = array();
        $arrPPF['nosupport'] = 0;  //0 hỗ trợ
        if($pcid == 42 && $price <4300000) $arrPPF['nosupport'] = 1;
        elseif($price <4000000 || $paytime < 0.3) $arrPPF['nosupport'] = 1;
        else
        {
            $arrPPF['totalprepaid'] = ceil($price * $prepaid);
            $giatrivay = $price - $arrPPF['totalprepaid'];
            if(($pcid == 42 && $giatrivay >=3000000  && $giatrivay <6000000 && ($paytime==9 || $paytime==12)) ||
               ($pcid == 42 && $giatrivay >=6000000  && $giatrivay <=1600000 && ($paytime==6 || $paytime==9 || $paytime==12)) ||

               (($pcid == 44 || $pcid == 48) && $giatrivay >=2500000  && $giatrivay <3000000 && ($paytime==15)) ||
               (($pcid == 44 || $pcid == 48) && $giatrivay >=3000000  && $giatrivay <6000000 && ($paytime==9 || $paytime==12 || $paytime==15)) ||
               (($pcid == 44 || $pcid == 48) && $giatrivay >=6000000  && $giatrivay <=19200000 && ($paytime==6 || $paytime==9 || $paytime==12 || $paytime==15)) ||
               ($giatrivay >=2500000  && $giatrivay <3000000 && ($paytime==15 || $paytime==18)) ||
               ($giatrivay >=3000000  && $giatrivay <6000000 && ($paytime==9 || $paytime==18 || $paytime==12 || $paytime==15)) ||
               ($giatrivay >=6000000  && $giatrivay <19400000 && ($paytime==6 || $paytime==9 || $paytime==18 || $paytime==12 || $paytime==15) )
            )
            {
                $heso = 0;
                if($giatrivay < 8000000 && $prepaid < 0.3)
                {
                    $heso = $installmentList[$type][79][29][$paytime];
                }
                elseif($giatrivay < 8000000 && $prepaid >= 0.3 && $prepaid < 0.4)
                {
                    $heso = $installmentList[$type][79][39][$paytime];
                }
                elseif($giatrivay < 8000000 && $prepaid >= 0.4)
                {
                    $heso = $installmentList[$type][79][40][$paytime];
                }//gia tri vay > 8M
                elseif($giatrivay >= 8000000 && $prepaid < 0.3)
                {
                    $heso = $installmentList[$type][80][29][$paytime];
                }
                elseif($giatrivay >= 8000000 && $prepaid >= 0.3 && $prepaid < 0.4)
                {
                    $heso = $installmentList[$type][80][39][$paytime];
                }
                elseif($giatrivay >= 8000000 && $prepaid >= 0.4)
                {
                    $heso = $installmentList[$type][80][40][$paytime];
                }
                $arrPPF['nosupport'] = 1;
                $arrPPF['monthly'] = ceil(($price - ($price * $prepaid))*$heso);
            }

        }

        return array('ACS' => $arrayACS, 'PPF' => $arrPPF);
    }
}