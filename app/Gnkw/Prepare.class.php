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
* Classe de préparation
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 12/04/2013
*/
class Prepare{
	private static $initialized = false;
	private $root;
	private $sourceDir;

	/**
	* Inclue toutes les classes récupérées
	* @param string $dirName Le répertoire
	* @param string $extension L'extension à inclure
	*/
	private function requireDir($dirName, $extension) {
		if ($handle = opendir($dirName)) {
			while (false !== ($entry = readdir($handle))) {
				if($entry != "." AND $entry != ".."){
					if (is_dir($dirName . $entry)) {
						$this->requireDir($dirName . $entry . '/', $extension);
					}
					else if(preg_match('#\.class\.php$#', $entry)){
						require_once($dirName.$entry);
					}
				}
			}
			closedir($handle);
		}
	}

	/**
	* Récupère toutes les classes
	* @param string $src Le lien des sources
	* @param string $root Le lien du dossier racine
	*/
	private function __construct($src, $root = null){
		$this->sourceDir = $src;
		if(isset($root)){
			$this->root = $root;
		}
		else{
			$this->root = realpath(dirname(__FILE__)).'/../../';
		}
		if(!is_dir($this->root . $this->sourceDir)){
			if(!mkdir($this->root . $this->sourceDir)){
				die();
			}
		}
		$this->requireDir($this->root . $this->sourceDir . '/', '.class.php');
	}

	/**
	* Prépare l'orientation objet (pattern Singleton)$
	* @param string $appLink Le lien des sources
	* @return Prepare L'objet unique
	*/
	public static function initialize($appLink, $root = null) {
		if(!self::$initialized){
			$prepare = new Prepare($appLink, $root);
			self::$initialized = true;
		}
		return $prepare;
	}
	
	/**
	* Récupère le lien absolu du dossier source
	* @return string Le lien
	*/
	public function getSourceLink() {
		return $this->root.$this->sourceDir.'/';
	}


}
?>