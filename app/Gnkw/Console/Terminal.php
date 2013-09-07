<?php
namespace Gnkw\Console;
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
 * Terminal class
 * @author Anthony REY <anthony.rey@mailoo.org>
 * @since 12/04/2013
 */
class Terminal {

	/**
	* Console arguments
	* @var array
	*/
	private $argv;
	/**
	* Sources link
	* @var string
	*/
	private $sourceLink;

	/**
	* Constructor
	* @param array $argv User parameters
	* @param string $sourceDir Sources directory
	*/
	public function __construct($argv = array(), $sourceLink) {
		$this->argv = $argv;
		$this->sourceLink = $sourceLink;
		if(!is_dir($this->sourceLink)){
			if(!mkdir($this->sourceLink)){
				die();
			}
		}
	}
	
	/**
	* Execute the terminal command
	* @return string Message to display
	*/
	public function execute() {
		if($this->getArgKey('-h') OR $this->getArgKey('--help'))
		{
			# Help command
			return $this->help();
		}
		else if($create = $this->getArgKey('create'))
		{
			# Create command
			$operation = $this->nextArg($create);
			if(null === $operation)
			{
				return '[Warning] No operation, you can use text or class arguments';
			}
			$namespace = $this->nextArg($create + 1);
			$classname = $this->nextArg($create + 2);
			if(null === $namespace OR null === $classname)
			{
				return '[Warning] No Namespace or Classname';
			}
			if($operation === "class")
			{
				return $this->createClass($namespace, $classname);
			}
			else if($operation === "test")
			{
			
				return $this->createTest($namespace, $classname);
			}
			return '[Warning] Invalid operation, you can use text or class arguments';
		}
		# Default option
		return $this->help();
	}
	
	/**
	* Create a class
	* @param string $namespaceArg Namespace of the class
	* @param string $classname Classname
	* @return string Message
	*/
	public function createClass($namespaceArg, $classname) {
		$namespace = preg_replace('#\/#', '\\', $namespaceArg);
		$dirs = explode("/", $namespaceArg);
		$path = $this->createDirs($dirs);
		if(null === $path)
		{
			return '[Error] Impossible to create files';
		}
		$stringFile = sprintf(
			file_get_contents($this->getDataLink('class.php')),
			$namespace,
			$classname,
			ucfirst(get_current_user()),
			date("d/m/Y")
		);
		if(is_file("$path/".$classname.".php")){
			return "[Warning] The class \"$classname\" already exist for the namespace \"$namespace\"";
		}
		else if(!file_put_contents("$path/".$classname.".php", $stringFile)){
			return;
		}
		else{
			$message = "Create class : \n======\n";
			$message .= $stringFile;
			$message .= "\n=====\nto : ".realpath($path).$classname.".php";
			return $message;
		}
		return '[Error] Error when creating class';
	}
	
	/**
	* Create a test class of an existing class
	* @param string $namespaceArg Namespace of the class
	* @param string $classname Classname
	* @return string Message
	*/
	public function createTest($namespaceArg, $classname) {
		$namespace = preg_replace('#\/#', '\\', $namespaceArg);
		$dirs = explode("/", $namespaceArg);
		$path = $this->createDirs($dirs);
		if(null === $path)
		{
			return '[Error] Impossible to create files';
		}
		$stringFile = sprintf(
			file_get_contents($this->getDataLink('test.php')),
			$namespace,
			$classname,
			ucfirst(get_current_user()),
			date("d/m/Y")
		);
		if(!is_file("$path/".$classname.".php"))
		{
			return "[Warning] The class \"$classname\" don't exist for the namespace \"$namespace\", so you can't create a test class from it";
		}
		if(is_file("$path/".$this->argv[4]."Test.test.php"))
		{
			return '[Warning] The class "'.$classname.'Test" already exist for the namespace "'.$namespace.'"';
		}
		else if(!file_put_contents("$path/".$classname."Test.php", $stringFile))
		{
			return;
		}
		else{
			$message = "Create test class : \n======\n";
			$message .= $stringFile;
			$message .= "\n=====\nto : ".realpath($path).$classname."Test.php";
			return $message;
		}
		return '[Error] Error when creating class';
	}
	
	/**
	* Gel help text
	* @return string Message
	*/
	public function help()
	{
		return file_get_contents($this->getDataLink('help.txt'));
	}
	
	/**
	* Create directories from an array architecture
	* @param array $dirs Array architecture
	* @return string $path The complete directory path
	*/
	private function createDirs(array $dirs)
	{
		$path = $this->sourceLink;
		for($i=0; $i<count($dirs); $i++){
			$path = $path . $dirs[$i] . '/';
			if(!is_dir($path)){
				if(!mkdir($path)){
					return null;
				}
			}
		}
		return $path;
	}
	
	/**
	* Get the data link for a filename
	* @return string The complete link
	*/
	private function getDataLink($filename)
	{
		return __DIR__ . '/data/' . $filename;
	}
	
	/**
	* Get key of an argument
	* @param string $arg The argument
	* @return integer|boolean The position of the argument if exist, if not : false
	*/
	private function getArgKey($arg)
	{
		return array_search($arg, $this->argv);
	}
	
	/**
	* Get the next argument by passing the key
	* @param integer $key Previous argument key
	* @return string|null The value of the next argument
	*/
	private function nextArg($key)
	{
		if(isset($this->argv[$key+1]))
		{
			return $this->argv[$key+1];
		}
		else
		{
			return null;
		}
	}

}

?>