<?php

abstract class House
{
	public function introduce()
	{
		echo "House " . $this->getHouseName();
		echo " of " . $this->getHouseSeat() . " : ";
		echo "\"" . $this->getHouseMotto() . "\"\n"; 
		
	}
	abstract public function getHouseName();
	abstract public function getHouseSeat();
	abstract public function getHouseMotto();
}


?>