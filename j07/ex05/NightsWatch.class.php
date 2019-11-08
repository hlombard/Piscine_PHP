<?php

class NightsWatch
{
	private $_fighters = array();

	public function recruit($person)
	{
		array_push($this->_fighters, $person);
	}

	public function fight()
	{
		foreach($this->_fighters as $fighter)
		{
			if ($fighter instanceof IFighter)
				$fighter->fight();
		}
	}

}


?>
