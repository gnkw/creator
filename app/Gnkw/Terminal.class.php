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
 * Classe Terminal
 * @author Anthony REY <anthony.rey@mailoo.org>
 * @since 12/04/2013
 */
class Terminal {
	private $prepare;
	private $argv;

	/**
	* Constructeur
	* @param array $argv Arguments de l'utilisateur
	* @param string $sourceDir Dossier des sources
	*/
	public function __construct($argv, $sourceDir, $root = null) {
		$this->argv = $argv;
		$this->prepare = Prepare::initialize($sourceDir, $root);
		if(!is_dir($this->prepare->getSourceLink())){
			die('The link "'.$this->prepare->getSourceLink().'" is not valid, please create required directories' . "\n");
		}
	}
	
	/**
	* Méthode execute
	*/
	public function execute() {
		if($this->argv[1] == "create"){
			if($this->argv[2] == "class"){
				if(isset($this->argv[3]) AND isset($this->argv[4])){
					$namespace = preg_replace('#\/#', '\\', $this->argv[3]);
					$path = $this->prepare->getSourceLink();
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
			else if($this->argv[2] == "test"){
				if(isset($this->argv[3]) AND isset($this->argv[4])){
					$namespace = preg_replace('#\/#', '\\', $this->argv[3]);
					$path = $this->prepare->getSourceLink();
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
		}
	}

}

?>