<?php
ini_set('memory_limit', '3024M');
class Core_OrderArchive extends Core_Object
{
    private $ociUsername = 'TGDD_NEWS_DM';
    private $ociPassword = 'blaBlad13nma40com';
    private $ociDatabaseName = 'ERP';
    private $ociHostname = '192.168.2.237';

    private $ociPort = '1521';
    private $ociSic = 'ORADC4';
    private $ociCharset = 'AL32UTF8';

    private $ociConnectionString = null;
    private $ociConnections = null;

    //constructor function
    public function __construct($argUsername = '', $argPassword = '', $argDatabasename = '')
    {
        if (!empty($argUsername)) {
            $this->ociUsername = $argUsername;
        }
        if (!empty($argPassword)) {
            $this->ociPassword = $argPassword;
        }
        if (!empty($ociDatabaseName)) {
            $this->ociDatabaseName = $argDatabasename;
        }
        $this->ociConnectionString = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=" . $this->ociHostname . ")(PORT=" . $this->ociPort . "))(CONNECT_DATA=(SID=" . $this->ociSic . ")))";
        $this->ociConnections      = oci_pconnect($this->ociUsername, $this->ociPassword, $this->ociConnectionString, $this->ociCharset);
        if (!$this->ociConnections) {
            $e = oci_error();
            var_dump($e);
        }
    }

    public function query($sql)
    {
        $stid = oci_parse($this->ociConnections, $sql);
        oci_execute($stid);
        $arrayReturn = array();
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $arrayReturn[] = $row;
        }

        return $arrayReturn;
    }

    public static function getOrderAchive($begin, $end, $count = false)
    {
        $orderarchives = new Core_OrderArchive;
        if ($count) {
            $sql = "				SELECT
										count(*) as dem 
									FROM 	
										ERP.VW_SALEORDER_DM a
									INNER JOIN 
										ERP.VW_PM_STORE_DM b ON a.OUTPUTSTOREID = b.STOREID
									WHERE 
												 b.COMPANYID  = '2' ";
            $rs  = $orderarchives->query($sql);

            return $rs[0]['DEM'];
        } else {
            $sql = " SELECT * FROM
							(
									SELECT
										rownum rnum,
										a.*
									FROM
										ERP.VW_SALEORDER_DM a
									INNER JOIN 
										ERP.VW_PM_STORE_DM b ON a.OUTPUTSTOREID = b.STOREID
									WHERE 
									rownum <=$begin 
									ORDER BY a.CREATEDATE ASC 

							) 
						WHERE 
									rnum >=$end";
            $rs  = $orderarchives->query($sql);

            return $rs;
        }


    }

    public static function getOrderAchiveBydate($begin, $end, $fromdate = '', $todate = '', $count = false, $ftodate = true)
    {


        $orderarchives = new Core_OrderArchive;
        if ($ftodate) {

            $wherefd = $fromdate == ''? '' : "a.CREATEDATE >= to_date('" . $fromdate ."')";
            $wheretd = $todate == ''? '' : "AND a.CREATEDATE  <= to_date('" . $todate."')";

        } else {

            $wherefd = $fromdate == ''? '' : "a.CREATEDATE > '" . $fromdate ."'";
            $wheretd = $todate == ''? '' : "AND a.CREATEDATE  <= '" . $todate."'";

        }

        if ($count) {
            $sql     = "	SELECT
						count(*) as DEM
					FROM
						ERP.VW_SALEORDER_DM a
					INNER JOIN 
						ERP.VW_PM_STORE_DM b ON a.OUTPUTSTOREID = b.STOREID
					WHERE 
								 $wherefd
								 $wheretd
				    order by a.CREATEDATE
				 ";
            $rs      = $orderarchives->query($sql);

            return $rs[0]['DEM'];

        } else {
            $sql = " SELECT * FROM
						(
								SELECT
									rownum rnum,
									a.*
								FROM
									ERP.VW_SALEORDER_DM a
								INNER JOIN 
									ERP.VW_PM_STORE_DM b ON a.OUTPUTSTOREID = b.STOREID
								WHERE 
											 rownum <=$end and
											 $wherefd
                                             $wheretd
                                order by a.CREATEDATE
						) 
						WHERE
								rnum >=$begin";
            $rs = $orderarchives->query($sql);

            return $rs;
        }


    }

    public static function ghisqlloi($fromdate, $begin, $end)
    {
        $orderarchives = new Core_OrderArchive();
        $wherefd       = $fromdate == ''? '' : "AND a.CREATEDATE >=" . $orderarchives->getTimeStamp($fromdate);
        $sql           = " SELECT * FROM
						(
								SELECT
									rownum rnum,
									a.*
								FROM
									ERP.VW_SALEORDER_DM a
								INNER JOIN 
									ERP.VW_PM_STORE_DM b ON a.OUTPUTSTOREID = b.STOREID
								WHERE 
											 rownum <=$end 
											 $wherefd
						)
					WHERE 
								rnum >=$begin";

        return $sql;

    }

    public static function getOrderAchiveByID($id)
    {
        $orderarchives = new Core_OrderArchive;
        $sql           = "  SELECT
							a.*
						FROM
							ERP.VW_SALEORDER_DM a
						WHERE 
					  	a.SALEORDERID='$id'
						";


        $rs            = $orderarchives->query($sql);

        return $rs[0]['CREATEDATE'];


    }

    public static function countgetOrderAchiveByDate($date = "")
    {
        $orderarchives = new Core_OrderArchive;
        $WHERE         = '';
        if ($date != '') {

            $date  = $orderarchives->getTimeStamp($date);
            $WHERE = "WHERE a.CREATEDATE>=$date";

        }


        $sql = "  SELECT count(*) as dem
	    				FROM ERP.VW_SALEORDER_DM a 
	    				INNER JOIN ERP.VW_PM_STORE_DM b ON a.OUTPUTSTOREID = b.STOREID
						$WHERE
						";

        $rs = $orderarchives->query($sql);

        return $rs[0]['DEM'];


    }


    public static function getOrderAchiveDetail($id)
    {
        $orderarchives = new Core_OrderArchive();

        $sql_detail = "SELECT
								a.*
							FROM
								ERP.VW_SALEORDERDETAIL_DM a
							WHERE 
								a.SALEORDERID = '$id'
							
									";

        $rsDetail = $orderarchives->query($sql_detail);

        return $rsDetail;
    }

    private function getTimeStamp($date)
    {
        $str = '';
        $str .= " to_timestamp('" . $date . "','DD-mon-YY HH12.MI.SS.FF6 AM.')";

        return $str;
    }

    /*
     * return arr[int][arr]
     */
    public static function getSaleorderNotComplete($limit = array(), $debug = false, $count = false)
    {
        $orderachived = new Core_OrderArchive();
        $strcount     = $count? ' count(*) as DEM ' : ' a.* ';
        $strbegin     = '';
        $strend       = '';
        $createdate   = $orderachived->getTimeStamp('01-Jan-13 01.00.00.000000 AM');
        if (!empty($limit)) {
            $strbegin .= "SELECT * FROM( ";
            $strend .= " AND rownum <= " . $limit['end'] . " ) WHERE rnum >=" . $limit['begin'];
            $strcount .= " ,rownum rnum ";
        }


        $sql = " SELECT $strcount FROM ERP.vw_saleorder_dm a
						where
						(
							a.ISDELIVERY = 0  OR
							a.ISINCOME = 0 OR
							a.ISOUTPRODUCT = 0 OR
							a.ISREVIEWED = 0
						 )
							AND a.ISDELETED = 0
							AND a.CREATEDATE >=" . $createdate;

        $sql = $strbegin . $sql . $strend;

        if ($debug) {
            return $sql;
        } else {
            $rs = $orderachived->query($sql);

            return $count? $rs[0]['DEM'] : $rs;
        }

    }

    public static function getMultiid($strid, $item = '')
    {

        $orderachived = new Core_OrderArchive();
        if ($item == '') {
            $item = 'ERP.VW_SALEORDER_DM.*';
        }

        $sql = 'SELECT ' . $item . '  FROM ERP.VW_SALEORDER_DM WHERE ERP.VW_SALEORDER_DM.SALEORDERID IN (' . $strid . ')';
        $rs  = $orderachived->query($sql);

        return $rs;

    }

    public static function getMultiidDetail($strid, $item = '')
    {

        $orderachived = new Core_OrderArchive();
        if ($item == '') {
            $item = 'ERP.ERP.vw_saleorderdetail_dm.*';
        }

        $sql = 'SELECT
					 ' . $item . '
					FROM
					  ERP.vw_saleorderdetail_dm
					WHERE
					  ERP.vw_saleorderdetail_dm.SALEORDERID IN  (' . $strid . ')';
        $rs  = $orderachived->query($sql);

        return $rs;

    }

    public static function getBySaleorderid($id)
    {
        $orderarchives = new Core_OrderArchive;
        $sql           = "  SELECT
							a.*
						FROM
							ERP.VW_SALEORDER_DM a
						WHERE
						a.SALEORDERID='$id'
						";
        $rs            = $orderarchives->query($sql);

        return $rs;
    }

}

