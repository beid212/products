<?php 


class DBHelper {
	
	protected $connection;
	protected $sTable;
	protected $arWhere;
	protected $arSelect;
	protected $arLimit;
	protected $arOrder;

	protected const ARR_FETCH = [
		'obj'=>PDO::FETCH_OBJ,
		'assoc'=>PDO::FETCH_ASSOC
	];

	public function __construct(string $db, string $host, string $dbname, string $user="root", string $password = '')
	{
		try{
			$this->connection = new PDO("$db:host=$host;dbname=$dbname",$user,$password);
		}
		catch(PDOExeption $exeption)
		{
			echo "Ошибка! ".$exeption->getMessage();
		}
	}

	public function table(string $sTable)
	{
		$this->sTable = $sTable;
		return $this;
	}

	public function where(string $sParam, string $sValue)
	{
		$this->arWhere[$sParam] = $sValue;
		return $this;
	}

	public function limit(int $iLimit=0, int $iOffset)
    {
        $this->arLimit[0] = $iLimit;
		$this->arLimit[1] = $iOffset;
		return $this;
    }

	public function sort(string $sColumn, string $sOrder = "")
	{
		$this->arOrder['column']  = $sColumn;
		$this->arOrder['order'] = $sOrder==="desc"?"DESC":"ASC";

		return $this;
	}

	public function get(string $sFetch = "assoc")
	{

		if(empty($this->arSelect))
		{
			$sSelect = "*";
		}
		$arParams = [];
		$sTable = $this->sTable;
		$sWhere = $sLimit = $sOrder = "";

		if(!empty($this->arWhere))
		{
			$sWhere = "WHERE ";
			foreach ($this->arWhere as $key => $value) {;
				$sWhere.="$key = :$key ";
				$arParams[$key]=$value;
			}
		}
		if(isset($this->arLimit))
        {
            $sLimit = "LIMIT {$this->arLimit[0]},{$this->arLimit[1]}";
        }
		if(isset($this->arOrder))
		{	
			$sOrder = "ORDER BY {$this->arOrder['column']} {$this->arOrder['order']}";
		}
		$prepare = $this->connection->prepare("SELECT $sSelect FROM $sTable $sWhere $sOrder $sLimit");
		$prepare->execute($arParams);

		$sFetch = array_key_exists($sFetch,self::ARR_FETCH)?$sFetch:"assoc";
		return $prepare->fetchAll(self::ARR_FETCH[$sFetch]);
	}

	public function update(array $arParams = [])
	{
		
		$sTable = $this->sTable;
		$sSets = $sWhere = "";
		$arSets = array_keys($arParams);
		$arSets = array_map(function($sKeyParam){
			return "$sKeyParam = :$sKeyParam";
		}, $arSets);
		$sSets = implode(", ",$arSets);
		if(!empty($this->arWhere))
		{
			$sWhere = "WHERE ";
			foreach ($this->arWhere as $key => $value) {;
				$sWhere.="$key = :$key ";
				$arParams[$key]=$value;
			}
		}
		$prepare = $this->connection->prepare("UPDATE $sTable SET $sSets $sWhere");
		$prepare->execute($arParams);
	}
	
	public function insert(array $arParams)
	{
		$sTable = $this->sTable;
		$arKeys = array_keys($arParams);
		$sParams = implode(', ', array_map(function ($value){return ":$value";},$arKeys ));
		$sNames = implode(', ',$arKeys);
		
		$prepare = $this->connection->prepare("INSERT INTO $sTable ($sNames) VALUES($sParams)");
		$prepare->execute($arParams);
	}
}