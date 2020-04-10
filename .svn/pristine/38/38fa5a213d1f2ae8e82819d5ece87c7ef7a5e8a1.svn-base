<?php

/**
 * core/class.internallink.php
 *
 * File contains the class used for Internallink Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Internallink Class
 */
Class Core_Internallink extends Core_Object
{

	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;

	public $id = 0;
	public $isarticle = 0;
	public $ispage = 0;
	public $isproduct = 0;
	public $isevent = 0;
	public $iscategoy = 0;
	public $isvendor = 0;
	public $isuppercase = 0;
	public $setting = '';
	public $keylink = '';
	public $exception = '';
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'internallink (
					il_setting,
					il_keylink,
					il_exception,
					il_status,
					il_datecreated
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
		(string)$this->setting,
		(string)$this->keylink,
		(string)$this->exception,
		(int)$this->status,
		(int)$this->datecreated
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'internallink
				SET il_setting = ?,
					il_keylink = ?,
					il_exception = ?,
					il_status = ?,
					il_datemodified = ?
				WHERE il_id = ?';

		$stmt = $this->db->query($sql, array(
		(string)$this->setting,
		(string)$this->keylink,
		(string)$this->exception,
		(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'internallink i
				WHERE i.il_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = (int)$row['il_id'];
		$this->setting = (string)$row['il_setting'];
		$this->keylink = (string)$row['il_keylink'];
		$this->exception = (string)$row['il_exception'];
		$this->status = (int)$row['il_status'];
		$this->datecreated = (int)$row['il_datecreated'];
		$this->datemodified = (int)$row['il_datemodified'];
			
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'internallink
				WHERE il_id = ?';
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
		$db = self::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'internallink i';

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
		$db = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'internallink i';

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
			$myInternallink = new Core_Internallink();
				
			$myInternallink->id = (int)$row['il_id'];
			$myInternallink->setting = (string)$row['il_setting'];
			$myInternallink->keylink = (string)$row['il_keylink'];
			$myInternallink->exception = (string)$row['il_exception'];
			$myInternallink->status = (int)$row['il_status'];
			$myInternallink->datecreated = (int)$row['il_datecreated'];
			$myInternallink->datemodified = (int)$row['il_datemodified'];
				
				
			$outputList[] = $myInternallink;
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
	public static function getInternallinks($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
		$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.il_id = '.(int)$formData['fid'].' ';
			
		if($formData['fstatus'] > 0)
		$whereString .= ($whereString != '' ? ' AND ' : '') . 'i.il_status = '.(int)$formData['fstatus'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
		$sorttype = 'DESC';
			

		if($sortby == 'id')
		$orderString = 'il_id ' . $sorttype;
		else
		$orderString = 'il_id ' . $sorttype;
			
		if($countOnly)
		return self::countList($whereString);
		else
		return self::getList($whereString, $orderString, $limit);
	}




	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLE] = 'Disable';


		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Enable'; break;
			case self::STATUS_DISABLE: $name = 'Disable'; break;
				
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if(($this->status == self::STATUS_ENABLE && $name == 'enable')
		|| ($this->status == self::STATUS_DISABLE && $name == 'disable'))
		return true;
		else
		return false;
	}


	public static function seointernallink($slug ,$content, $isname) {
		$formData['fstatus'] = self::STATUS_ENABLE;
		$setting = self::getInternallinks($formData, 'id', 'DESC');
		$link = 0;
		if(!empty($setting)){
			foreach ($setting as $seointernal) {

				if (!empty($seointernal->exception)) {
					foreach (explode("\n", $seointernal->exception) as $exceptionslug) {
						if (strcmp(trim($slug),trim($exceptionslug)) == 0) {
							return $content;
						}
					}
				}

				$option = unserialize($seointernal->setting);

				if ($option[$isname] == 1){


					if ($option['fmaxlinkarticle'] > 0) {
						$maxlinkarticle = $option['fmaxlinkarticle'];
					}else {
						$maxlinkarticle = 0;
					}
					if ($option['fmaxlinkkey'] > 0) {
						$fmaxlinkkey = $option['fmaxlinkkey'];
					}else {
						$fmaxlinkkey = -1;
					}
					if ($option['fmaxurlsame'] > 0) {
						$fmaxurlsame = $option['fmaxurlsame'];
					}else {
						$fmaxurlsame = 0;
					}

					$ftarget = $option['ftarget'];
					$fisheading = $option['fisheading'];
					if ($option['fisuppercase'] > 0) {
						$isuppercase = $option['fisuppercase'];
					}else {
						$isuppercase = 0;
					}

					$target = '';
					if ($ftarget == 1) {
						$target = 'target="_blank"';
					}

					// Không bao gồm các thẻ heading
					if ($fisheading == 1) {
						$content = preg_replace('%(<h.*?>)(.*?)(</h.*?>)%sie', "'\\1'.insertspecialchars('\\2').'\\3'", $content);
					}
					
					// Không bao gồm chuỗi liên kết
					$content = preg_replace('%(<a.*?>)(.*?)(</a.*?>)%sie', "'\\1'.insertspecialchars('\\2').'\\3'", $content);

					$reg =	$isuppercase ? '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))($name)/msU' : '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))($name)/imsU';	

					//$reg =	$isuppercase ? '/($name)/msU' : '/($name)/imsU';

					$urls = array();

					$content = " $content ";

					if (!empty($seointernal->keylink)) {
						$kw_array = array();
						foreach (explode("\n", $seointernal->keylink) as $line) {
							$chunks = array_map('trim', explode(",", $line));
							$total_chuncks = count($chunks);
							if($total_chuncks > 2) {
								$i = 0;
								$url = $chunks[$total_chuncks-1];
								while($i < $total_chuncks-1) {
									if (!empty($chunks[$i])) $kw_array[$chunks[$i]] = $url;
									$i++;
								}
							} else {
								list($keyword, $url) = array_map('trim', explode(",", $line, 2));
								if (!empty($keyword)) $kw_array[$keyword] = $url;
							}

						}
					}

					foreach ($kw_array as $name=>$url) {

						if ((!$maxlinkarticle || ($link < $maxlinkarticle)) && (!$fmaxlinkkey || $urls[$url] < $fmaxlinkkey) ) {
								
							$name = str_replace(',','|',$name);

							$replace = "<a $target title=\"$1\" href=\"$url\">$1</a>";
							$regexp = str_replace('$name', $name, $reg);
							$newtext = preg_replace($regexp, $replace, $content, $fmaxlinkkey);
							if ($newtext != $content) {
								$link++;
								$content = $newtext;
								if (!isset($urls[$url])) {
									$urls[$url] = 1;
								}else {
									$urls[$url]++;
								}
							}

						}
					}

					//echo $content;die;
					if ($fisheading == 1) {
						$content = preg_replace('%(<h.*?>)(.*?)(</h.*?>)%sie', "'\\1'.removespecialchars('\\2').'\\3'", $content);
						$content = stripslashes($content);
					}
					
					$content = preg_replace('%(<a.*?>)(.*?)(</a.*?>)%sie', "'\\1'.removespecialchars('\\2').'\\3'", $content);
					$content = stripslashes($content);

				}
			}
		}
		return $content;


	}
}

function insertspecialchars($str) {
	$strarr = str2arr($str);
	$str = implode("<!---->", $strarr);
	return $str;
}
function removespecialchars($str) {
	$strarr = explode("<!---->", $str);
	$str = implode("", $strarr);
	$str = stripslashes($str);
	return $str;
}
function str2arr($str) {
	$chararray = array();
	for($i=0; $i < strlen($str); $i++){
		array_push($chararray,$str{$i});
	}
	return $chararray;
}