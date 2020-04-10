<?php
class Oracle
{
	private $ociUsername = 'TGDD_NEWS_DM';
    private $ociPassword = 'blaBlad13nma40com';
    public static $ociDatabaseName = 'TGDD_NEWS';
    private $ociHostname = '192.168.2.237';
    
    private $ociPort = '1521';//1521
    private $ociSic = 'ORADC4';
	private $ociCharset = 'UTF8';
    
    private $ociConnectionString = null;
    public $ociConnections = null;
    public $query_resource;

	//constructor function
	public function __construct($argUsername='',$argPassword='',$argDatabasename='')
	{
		if(!empty($argUsername)) $this->ociUsername = $argUsername;
        if(!empty($argPassword)) $this->ociPassword = $argPassword;
        if(!empty($ociDatabaseName)) $this->ociDatabaseName = $argDatabasename;
        
        $this->ociConnectionString = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=".$this->ociHostname .")(PORT=".$this->ociPort."))(CONNECT_DATA=(SID=".$this->ociSic.")))";
        
		$this->ociConnections = oci_connect($this->ociUsername,$this->ociPassword, $this->ociConnectionString,$this->ociCharset);
        
        if (!$this->ociConnections) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
	}
    
    public  function query($sql){
        $stid = oci_parse($this->ociConnections, $sql);
        if($stid){
            @oci_execute($stid);
            if(@oci_execute($stid))
			{
				$arrayReturn = array();
            
				while ($row = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
					$arrayReturn[] = $row;
				}
				return $arrayReturn;
			}
			else
			{
				$e = oci_error($stid);
				echo htmlentities($e['message']);
			}
        }
        return false;        
    }
}
