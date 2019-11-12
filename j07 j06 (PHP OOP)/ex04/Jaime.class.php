<?php

class Jaime extends Lannister
{
	public function sleepWith($person){
		if ($person instanceof Sansa)
		{
			echo "Let's do this.\n";
		}
		else if ($person instanceof Cersei)
		{
			echo "With pleasure, but only in a tower in Winterfell, then.\n";
		}
		else
		{
			echo "Not even if I'm drunk !\n";
		}
	}
}

?>
