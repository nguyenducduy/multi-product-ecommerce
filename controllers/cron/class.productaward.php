<?php
class Controller_Cron_ProductAward extends Controller_Cron_Base
{
	public function indexAction()
	{

	}

	/**
	 * @description Sync product award from ERP
	 */
	public function syncproductawardAction()
	{
		set_time_limit(0);
		$counter = 0;
		$today = strtoupper(date('d-M-y' , time()));

		$oracle = new Oracle();

		$sql = 'SELECT pw.*  FROM ERP.VW_PRODUCTREWARD_DM pw WHERE UPDATEDDATE >= TO_DATE(\''.$today.'\')';

		$results = $oracle->query($sql);

		foreach ($results as $result)
		{
			//check product award is exist
			$checker = Core_ProductAward::getProductAwards(array('fpbarcode' => $result['PRODUCTID'] , 'fpoid' => $result['OUTPUTTYPEID'] , 'fppaid' => $result['PRICEAREAID']) , 'id' , 'ASC' , '' , true);
			if($checker > 0)
			{
				$myproductaward = new Core_ProductAward();
				$myproductaward->pbarcode = $result['PRODUCTID'];
				$myproductaward->poid = $result['OUTPUTTYPEID'];
				$myproductaward->ppaid = $result['PRICEAREAID'];
				$myproductaward->getDataByBarcode();

				$myproductaward->totalawardforstaff = $result['TOTALREWARDFORSTAFF'];
				$myproductaward->updatedatedoferp = $myproductaward->updatedatedoferp = $this->formatTime($result['UPDATEDDATE']);

				if($myproductaward->updateData())
				{
					$counter++;
				}
			}
			else
			{
				$myproductaward = new Core_ProductAward();
				$myproductaward->pbarcode = $result['PRODUCTID'];
				$myproductaward->poid = $result['OUTPUTTYPEID'];
				$myproductaward->ppaid = $result['PRICEAREAID'];
				$myproductaward->totalawardforstaff = $result['TOTALREWARDFORSTAFF'];
				$myproductaward->updatedatedoferp = $this->formatTime($result['UPDATEDDATE']);

				if($myproductaward->addData() > 0)
				{
					$counter++;
				}
			}
			unset($myproductaward);
			unset($result);
			unset($checker);
		}

		echo 'So luong record thuc thi la : ' . $counter;
	}
	
	/**
	 * 
	 * Update productawrad of product
	 */
	public function updateproductawardAction()
	{
		set_time_limit(0);
		$counter = 0;
		$sql = 'SELECT sum(pw_totalawardforstaff) as total , p_barcode FROM '.TABLE_PREFIX. 'product_award GROUP BY p_barcode';
		$stmt = $this->registry->db->query($sql);
		
		while ($row = $stmt->fetch())
		{
			$sql = 'SELECT p_id , p_productaward FROM ' . TABLE_PREFIX . 'product WHERE p_barcode = ?';
			$row1 = $this->registry->db->query($sql , array($row['p_barcode']))->fetch();
			
			if((int)$row1['p_id'] > 0)
			{
				if((float)$row1['p_productaward'] != (float)$row['total'])
				{
					$sql = 'UPDATE ' . TABLE_PREFIX . 'product 
							SET p_productaward = ? 
							WHERE p_barcode = ?';
					$stmt1 = $this->registry->db->query($sql , array($row['total'] , $row['p_barcode']));
					if($stmt1)					
						$counter++;					
				}
			}
			
			unset($row);
			unset($row1);
			unset($stmt1);
		}
		
		echo 'So luong record thuc thi : ' . $counter;
	}

	private function formatTime($str, $time = 'H:i:s')
    {
        $date =  0;
        $str = trim($str);
        if(!empty($str) && $str != '0' &&  $str != 0)
        {
            $dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $str);
            if(!empty($time))
            {
                $date =  strtotime($dateUpdated->format('Y-m-d '.$time));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'),$dateUpdated->format($time));
            }
            else {
                $date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
            }
        }
        return $date;
    }
}