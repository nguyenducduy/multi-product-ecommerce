<?php

/**
 * core/class.program.php
 *
 * File contains the class used for Program Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Program extends Core_Object
{

	public $uid = 0;
	public $id = 0;
	public $name = "";
	public $description = "";
	public $storelist = "";
	public $executetime = "";
	public $startdate = 0;
	public $dateend = 0;
	public $posmobj = null;
	public $noteguideobj = null;
	public $programposition = null;
	public $listpositionsobject = null;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'program (
					uid,
					p_name,
					p_description,
					p_storelist,
					p_executetime,
					p_startdate,
					p_dateend
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->name,
					(string)$this->description,
					(string)$this->storelist,
					(string)$this->executetime,
					(int)$this->startdate,
					(int)$this->dateend
					))->rowCount();

		$this->id = $this->db->lastInsertId();

		if($this->id > 0){
			if(!empty($this->posmobj) && !empty($_FILES['fimageguidearr'])){
				foreach($this->posmobj as $poid => $indeximg)
				{
					if(!empty($_FILES['fimageguidearr']['name'][$indeximg])){
						$myProgramposition = new Core_ProgramPosition();
						$myProgramposition->poid = (int)$poid;
						$myProgramposition->pid = (int)$this->id;
						$myProgramposition->noteguide = (string)$this->noteguideobj[$poid];
						$curid = $myProgramposition->addData();
						if($curid > 0){
							$imgpath = $myProgramposition->uploadImage($_FILES['fimageguidearr']['name'][$indeximg],$_FILES['fimageguidearr']['tmp_name'][$indeximg]);
							$myProgramposition->image = $imgpath;
							$myProgramposition->updateData();
							//add program postion store
							$liststoreid = explode(',', $this->storelist);

							foreach($liststoreid as $sid){
								if(!empty($sid)){
									$myProgramPosStore = new Core_ProgramPositionStore();
									$myProgramPosStore->sid = $sid;
									$myProgramPosStore->ppid = $curid;
									$myProgramPosStore->pid = $this->id;
									$myProgramPosStore->addData();
								}
							}
						}
					}
				}
				//
			}
		}

		return $this->id;
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{

		$sql = 'UPDATE ' . TABLE_PREFIX . 'program
				SET uid = ?,
					p_name = ?,
					p_description = ?,
					p_storelist = ?,
					p_executetime = ?,
					p_startdate = ?,
					p_dateend = ?
				WHERE p_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->name,
					(string)$this->description,
					(string)$this->storelist,
					(string)$this->executetime,
					(int)$this->startdate,
					(int)$this->dateend,
					(int)$this->id
					));
//echodebug($this->noteguideobj, true);
		if($stmt){
			if(!empty($this->posmobj) && !empty($_FILES['fimageguidearr']['name'][0])){
				$this->deleteChildTable();
				foreach($this->posmobj as $poid => $indeximg)
				{
					if(!empty($_FILES['fimageguidearr']['name'][$indeximg])){

						$myProgramposition = new Core_ProgramPosition();
						$myProgramposition->poid = (int)$poid;
						$myProgramposition->pid = (int)$this->id;
						$myProgramposition->noteguide = (string)$this->noteguideobj[$poid];
						$curid = $myProgramposition->addData();
						if($curid > 0){
							$imgpath = $myProgramposition->uploadImage($_FILES['fimageguidearr']['name'][$indeximg],$_FILES['fimageguidearr']['tmp_name'][$indeximg]);
							$myProgramposition->image = $imgpath;
							$myProgramposition->updateData();
							//add program postion store
							$liststoreid = explode(',', $this->storelist);

							foreach($liststoreid as $sid){
								if(!empty($sid)){
									$myProgramPosStore = new Core_ProgramPositionStore();
									$myProgramPosStore->sid = $sid;
									$myProgramPosStore->pid = (int)$this->id;
									$myProgramPosStore->ppid = $curid;
									$myProgramPosStore->addData();
								}
							}
						}
					}
				}
				//
			}
			elseif(!empty($this->listpositionsobject)){
				foreach($this->listpositionsobject as $pos){
					$getProgramPos = Core_ProgramPosition::getProgramPositions(array('fpoid' => $pos->id, 'fpid' => $this->id),'','',1);
					if(!empty($getProgramPos[0])){
						$oneprogrampost = new Core_ProgramPosition($getProgramPos[0]->id);
						$oneprogrampost->noteguide = (string)$this->noteguideobj[$pos->id];
						if(!empty($_FILES['fimagepos']['name'][$pos->id])){
							$imgpath = $oneprogrampost->uploadImage($_FILES['fimagepos']['name'][$pos->id],$_FILES['fimagepos']['tmp_name'][$pos->id]);
							if(!empty($imgpath)){
								$oneprogrampost->deleteImage();
								$oneprogrampost->image = $imgpath;
								$oneprogrampost->updateData();
							}
						}
						elseif(isset($_FILES['fimagepos']['name'][$pos->id])){
							//$getProgramPos[0]->delete();
							$oneprogrampost->delete();
						}
						else{
							$oneprogrampost->updateData();
						}
					}
					else{
						if(!empty($_FILES['fimagepos']['name'][$pos->id])){
							$oneprogrampost = new Core_ProgramPosition();
							$imgpath = $oneprogrampost->uploadImage($_FILES['fimagepos']['name'][$pos->id],$_FILES['fimagepos']['tmp_name'][$pos->id]);
							if(!empty($imgpath)){
								$oneprogrampost->noteguide = (string)$this->noteguideobj[$pos->id];
								$oneprogrampost->poid = (int)$pos->id;
								$oneprogrampost->pid = (int)$this->id;
								$oneprogrampost->image = $imgpath;
								$curid = $oneprogrampost->addData();
								if($curid > 0){
									$liststoreid = explode(',', $this->storelist);
									if(!empty($liststoreid)){
										foreach($liststoreid as $sid){
											$myProgramPosStore = new Core_ProgramPositionStore();
											$myProgramPosStore->sid = $sid;
											$myProgramPosStore->ppid = $curid;
											$myProgramPosStore->pid = $this->id;
											$myProgramPosStore->addData();
										}
									}
								}
							}
						}
					}
				}
				$getlistpositionstore = Core_ProgramPositionStore::getProgramPositionStores(array('fpid' => $this->id),'','');
				if(!empty($getlistpositionstore)){
					$liststoreid = explode(',', $this->storelist);
					$liststoresexclude = $liststoreid;
					$allppids = array();
					foreach($getlistpositionstore as $propstore){
						if(!in_array($propstore->sid, $liststoreid)){
							$propstore->delete();
						}
						else{
							unset($liststoresexclude[array_search($propstore->sid, $liststoreid)]);
						}
						if(!in_array($propstore->ppid, $allppids)){
							$allppids[] = $propstore->ppid;
						}
					}
					if(!empty($liststoresexclude) && !empty($allppids)){
						foreach($liststoreid as $sid){
							if(!empty($sid)){
								foreach($allppids as $curid){
									$myProgramPosStore = new Core_ProgramPositionStore();
									$myProgramPosStore->sid = $sid;
									$myProgramPosStore->ppid = $curid;
									$myProgramPosStore->pid = $this->id;
									$myProgramPosStore->addData();
								}
							}
						}
					}
				}
			}
			return true;
		}
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'program p
				WHERE p.p_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();
		$this->uid = $row['uid'];
		$this->id = $row['p_id'];
		$this->name = $row['p_name'];
		$this->description = $row['p_description'];
		$this->storelist = $row['p_storelist'];
		$this->executetime = $row['p_executetime'];
		$this->startdate = $row['p_startdate'];
		$this->dateend = $row['p_dateend'];
		$this->programposition = Core_ProgramPosition::getProgramPositions(array('fpid' => (int)$id), 'poid', 'DESC');
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$this->deleteChildTable();
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'program
				WHERE p_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

	public function deleteChildTable(){
		$rspp = Core_ProgramPosition::getProgramPositions(array('fpid' => $this->id),'','');
		if($rspp){
			foreach($rspp as $rsrow){
				$listprogramposstore = Core_ProgramPositionStore::getProgramPositionStores(array('fppid' => $rsrow->id), '','');
				if(!empty($listprogramposstore)){
					foreach($listprogramposstore as $propstore){
						$propstore->deleteImage();
					}
					$sql = 'DELETE FROM ' . TABLE_PREFIX . 'program_position_store WHERE pp_id = ?';
					$rowCount = $this->db->query($sql, array($rsrow->id))->rowCount();
				}
				$rsrow->deleteImage();
			}
		}

		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'program_position WHERE p_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();
	}

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where)
	{
		global $db;

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'program p';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'program p';

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
			$myProgram = new Core_Program();

			$myProgram->uid = $row['uid'];
			$myProgram->id = $row['p_id'];
			$myProgram->name = $row['p_name'];
			$myProgram->description = $row['p_description'];
			$myProgram->storelist = $row['p_storelist'];
			$myProgram->executetime = $row['p_executetime'];
			$myProgram->startdate = $row['p_startdate'];
			$myProgram->dateend = $row['p_dateend'];
			$myProgram->programposition = Core_ProgramPosition::getProgramPositions(array('fpid' => (int)$id), 'poid', 'DESC');

            $outputList[] = $myProgram;
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
	public static function getPrograms($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.uid = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fstorelist'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_storelist = "'.Helper::unspecialtext((string)$formData['fstorelist']).'" ';

		if (isset($formData['fenddatenow']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_dateend >= "'.(int)time().'" ';

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'storelist')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_storelist LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (p.p_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (p.p_storelist LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'p_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'p_name ' . $sorttype;
		elseif($sortby == 'storelist')
			$orderString = 'p_storelist ' . $sorttype;
		else
			$orderString = 'p_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}