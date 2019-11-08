<?php

class Vertex
{
	public static $verbose = false;
	private $_w = 1.0;
	private $_x;
    private $_y;
	private $_z;
	private $_color;

	public function __construct($array)
	{
		if (array_key_exists('x', $array) && array_key_exists('y', $array) && array_key_exists('z', $array))
		{
			$this->_x = $array['x'];
			$this->_y = $array['y'];
			$this->_z = $array['z'];
			if (array_key_exists('w', $array))
				$this->_w = $array['w'];
			if (array_key_exists('color', $array) && $array['color'] instanceof Color)
				$this->_color = $array['color'];
			else
				$this->_color = new Color(array('red' => 255,'green' => 255, 'blue' => 255));
		}
		if (self::$verbose)
			printf($this . " constructed\n");
	}

	public function getX() { return $this->_x; }
    public function getY() { return $this->_y; }
    public function getZ() { return $this->_z; }
    public function getW() { return $this->_w; }
    public function getColor() { return $this->_color; }

    public function setX($value) { $this->_x = $value; }
    public function setY($value) { $this->_y = $value; }
    public function setZ($value) { $this->_z = $value; }
    public function setW($value) { $this->_w = $value; }
	public function setColor(Color $value) { $this->_color = $value; }
	
	public static function doc()
	{
		if ($file = file_get_contents('Vertex.doc.txt'))
			return ($file);
	}
	public function __tostring()
	{
		if (self::$verbose)
			return (sprintf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, $this->_color )", $this->_x, $this->_y, $this->_z, $this->_w));
		else
			return (sprintf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f )", $this->_x, $this->_y, $this->_z, $this->_w));
	}
	public function __destruct()
	{
		if (self::$verbose)
			printf($this . " destructed\n");
	}
}


?>
