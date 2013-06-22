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
 * Terminal class
 * @author Anthony REY <anthony.rey@mailoo.org>
 * @since 12/04/2013
 */
class Terminal {
	private $argv;
	private $sourceLink;

	/**
	* Constructor
	* @param array $argv User parameters
	* @param string $sourceDir Sources directory
	*/
	public function __construct($argv, $sourceLink) {
		$this->argv = $argv;
		$this->sourceLink = $sourceLink;
		Autoload::init($this->sourceLink);
		if(!is_dir($this->sourceLink)){
			if(!mkdir($this->sourceLink)){
				die();
			}
		}
	}
	
	/**
	* Execute the terminal
	*/
	public function execute() {
		if($this->argv[1] == "create"){
			if($this->argv[2] == "class"){
				$this->createClass();
			}
			else if($this->argv[2] == "test"){
				$this->createTest();
			}
		}
		else if($this->argv[1] == "transform")
		{
			$this->transform();
		}
	}
	
	/**
	* Create a class
	*/
	private function createClass() {
		if(isset($this->argv[3]) AND isset($this->argv[4])){
			$namespace = preg_replace('#\/#', '\\', $this->argv[3]);
			$path = $this->sourceLink;
			$dirs = explode("/", $this->argv[3]);
			for($i=0; $i<count($dirs); $i++){
				$path = $path . $dirs[$i] . '/';
				if(!is_dir($path)){
					if(!mkdir($path)){
						die();
					}
				}
				
			}
			$stringFile = "<?php\nnamespace $namespace;\n\n/**\n* ".$this->argv[4]." class\n* @author ".ucfirst(get_current_user())."\n* @since ".date("d/m/Y")."\n*/\nclass ".$this->argv[4]."{\n\n\t/**\n\t* ".$this->argv[4]." constructor\n\t*/\n\tpublic function __construct(){\n\t\techo \"Hello ".$this->argv[4]." !\\n\";\n\t}\n}\n?>\n";
			if(is_file("$path/".$this->argv[4].".class.php")){
				die("The class \"".$this->argv[4]."\" already exist for this namespace\n");
			}
			else if(!file_put_contents("$path/".$this->argv[4].".class.php", $stringFile)){
				die();
			}
			else{
				echo "Create class : \n======\n";
				echo $stringFile;
				echo "=====\nto : $path".$this->argv[4].".class.php\n";
			}
		}
	}
	
	/**
	* Create a test class of a class
	*/
	private function createTest() {
		if(isset($this->argv[3]) AND isset($this->argv[4])){
			$namespace = preg_replace('#\/#', '\\', $this->argv[3]);
			$path = $this->sourceLink;
			$dirs = explode("/", $this->argv[3]);
			for($i=0; $i<count($dirs); $i++){
				$path = $path . $dirs[$i] . '/';
				if(!is_dir($path)){
					if(!mkdir($path)){
						die();
					}
				}
				
			}
			$stringFile = "<?php\nnamespace $namespace;\n\n/**\n* ".$this->argv[4]." test class\n* @author ".ucfirst(get_current_user())."\n* @since ".date("d/m/Y")."\n*/\nclass ".$this->argv[4]."Test extends \\PHPUnit_Framework_TestCase{\n\tpublic function setUp() {\n\t\trequire_once(\"".$this->argv[4].".class.php\");\n\t}\n}\n?>\n";
			if(!is_file("$path/".$this->argv[4].".class.php")){
				die("The class \"".$this->argv[4]."\" don't exist, so you can't do a test file for it\n");
			}
			if(is_file("$path/".$this->argv[4]."Test.test.php")){
				die("The class \"".$this->argv[4]."Test\" already exist for this namespace\n");
			}
			else if(!file_put_contents("$path/".$this->argv[4]."Test.test.php", $stringFile)){
				die();
			}
			else{
				echo "Create test class : \n======\n";
				echo $stringFile;
				echo "=====\nto : $path".$this->argv[4].".class.php\n";
			}
		}
	}

	/**
	* Transfor a file by extension
	*/
	private function transform() {
		if(isset($this->argv[2]) AND isset($this->argv[3])){
			$match = preg_replace('#\.#', '\.', $this->argv[2]);
			$extension = $this->argv[3];
			echo 'Transforming files …'."\n";
			$this->transformDir($this->sourceLink, $match, $extension);
			echo '… files transformed'."\n";
		}
	}
	
	/**
	* Transformation
	* @param string $dirName The current directory
	* @param string $match The matching pattern to tranform
	* @param string $extension The new extension
	*/
	private function transformDir($dirName, $match, $extension) {
		if ($handle = opendir($dirName)) {
			while (false !== ($entry = readdir($handle))) {
				if($entry != "." AND $entry != ".."){
					if (is_dir($dirName . $entry)) {
						$this->transformDir($dirName . $entry . '/', $match, $extension);
					}
					else if(preg_match('#'.$match.'$#', $entry)){
						$currentEntry = $entry;
						$newEntry = preg_replace('#'.$match.'$#', $extension, $entry);
						rename($dirName.$currentEntry, $dirName.$newEntry);
						echo '[RENAME] "' . $dirName.$currentEntry . '" to "' . $dirName.$newEntry . '"' ."\n";
					}
				}
			}
			closedir($handle);
		}
	}

}

?>