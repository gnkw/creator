<?php
namespace Gnkw;
/*
* Copyright (c) 2012 GNKW
*
* This file is part of GNKW Creator.
*
* GNKW Creator is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* GNKW Creator is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with GNKW Creator.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
* Autoload class to require classes
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 22/06/2013
*/
class Autoload {

	private static $loader;
	private $path;

	/**
	* Initialization of the loader
	* @param string $path Path to the source directory
	* @return Gnkw\Autoload The loader
	*/
	public static function init($path)
	{
		if (null == self::$loader)
		{
			self::$loader = new self($path);
		}

		return self::$loader;
	}

	/**
	* Constructor
	* @param string $path Path to the source directory
	*/
	private function __construct($path)
	{
		$this->path = $path;
		spl_autoload_register(array($this,'loadClass'));
		spl_autoload_register(array($this,'loadTest'));
		spl_autoload_register(array($this,'load'));
	}

	/**
	* Load a class file
	* @param string $class The class to load
	*/
	public function loadClass($class)
	{
		$this->load($class, 'class.php');
	}
	
	
	/**
	* Load a test class file
	* @param string $class The test class to load
	*/
	public function loadTest($class)
	{
		$this->load($class, 'test.php');
	}
	
	/**
	* Load a standard class file
	* @param string $class The class to load
	* @param string $ext The extension of the file
	*/
	public function load($class, $ext = 'php')
	{
		$class = preg_replace('#\\\\#','/', $class);
		$path = $this->path . $class . '.'.$ext;
		if(is_file($path))
		{
			require_once($path);
		}
	}
}
?>
