<?php

Class color
{
	public static $verbose = false;

	public function __construct($array)
	{
		if (array_key_exists('rgb', $array))
		{
			$this->red = intval(($array['rgb'] >> 16) & 0xff);
			$this->green = intval(($array['rgb'] >> 8) & 0xff);
			$this->blue = intval($array['rgb'] & 0xff);
		}
		else if (array_key_exists('red', $array) && array_key_exists('green', $array) && array_key_exists('blue', $array))
		{
			$this->red = intval($array['red']);
			$this->green = intval($array['green']);
			$this->blue = intval($array['blue']);
		}
		if (self::$verbose == true)
		{
			printf("Color( red: %3d, green: %3d, blue: %3d ) constructed.\n",
				$this->red, $this->green, $this->blue);
		}
	}

	public function add($new_color)
	{
		$tmp = array('red' => $this->red, 'green' => $this->green, 'blue' => $this->blue);
		foreach ($tmp as $key => &$elem)
			$elem += $new_color->$key;

		$new = new Color($tmp);
		return $new;
	}
	public function sub($new_color)
	{
		$tmp = array('red' => $this->red, 'green' => $this->green, 'blue' => $this->blue);
		foreach ($tmp as $key => &$elem)
			$elem -= $new_color->$key;

		$new = new Color($tmp);
		return $new;
	}
	public function mult($new_color)
	{
		$tmp = array('red' => $this->red, 'green' => $this->green, 'blue' => $this->blue);
		foreach ($tmp as &$elem)
			$elem *= $new_color;

		$new = new Color($tmp);
		return $new;
	}

	public function __toString()
	{
		return (sprintf("Color( red: %3d, green: %3d, blue: %3d )", $this->red, $this->green, $this->blue));
	}
	public function doc()
	{
		if ($file = file_get_contents('Color.doc.txt'))
			return ($file);
	}
	public function __destruct()
	{
		if (self::$verbose)
		{
			printf("Color( red: %3d, green: %3d, blue: %3d ) destructed.\n",
				$this->red, $this->green, $this->blue);
		}
	}
}


?>
