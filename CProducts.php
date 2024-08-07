<?php 

class CProducts extends DBHelper
{

	public function __construct(string $db, string $host, string $dbname, string $user="root", string $password = '')
	{
        parent::__construct($db,$host,$dbname,$user,$password);
        $this->sTable = "products";
	}
	public function visible(bool $bVisible)
	{
		if($bVisible)
		{
			$this->update(['visible'=>1]);
		}
		else 
		{
			$this->update(['visible'=>0]);
		}
	}
	public function quantity(int $iQuantity, string $sAction)
	{
		$product = $this->get("obj")[0];

		if($sAction === "plus")
		{
			$this->update(["product_quantity"=>$product->product_quantity+$iQuantity]);
		}
		else if($sAction === "minus"&&$product->product_quantity-$iQuantity>=0)
		{
			$this->update(["product_quantity"=>$product->product_quantity-$iQuantity]);
		}
	}
}