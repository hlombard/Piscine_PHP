<?php


class UnholyFactory
{
	private $array = array();
	private $class = array();

	public function absorb($type)
	{
		if ($type instanceof Fighter)
		{
			$name = $type->isNamed();
			if (in_array($name, $this->array))
				echo "(Factory already absorbed a fighter of type " . $name . ")\n";
			else
			{
				echo "(Factory absorbed a fighter of type " . $name . ")\n";
				array_push($this->array, $name);
				$this->class[$name] = $type;
			}
		}
		else
			echo "(Factory can't absorb this, it's not a fighter)\n";
	}
	public function fabricate($elem)
	{
		if (in_array($elem, $this->array))
		{
			echo "(Factory fabricates a fighter of type " . $elem . ")\n";
			return ($this->class[$elem]);
		}
		else
		{
			echo "(Factory hasn't absorbed any fighter of type " . $elem . ")\n";
			return (null);
		}
	}
	public function fight($target){}
}

?>
