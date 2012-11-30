<?
/**
 * 
 *
 * @author AndreaG
 * @version 0.0.1
 * @copyright SmartGaP s.r.l.
 * @package esyFileManager
 */

/**
 * CLASSI FILE MANAGER
 */
 
 /**
  * undocumented class
  *
  * @package esyFileManager
  * @author  AndreaG
  */
 class esyFileManager {
 	
	private $app_folder; 
	private $files_folder;
	
 	function __construct() {
		$app_folder=APP_FOLDER;
		$files_folder=$_SERVER['DOCUMENT_ROOT'].FILES_FOLDER;
 	}
	
	/**
	 * listFiles()
	 *
	 * @return Elencha i files di un determinato tipo contenuti nella directory specificata
	 * @author AndreaG
	 */
	private function listFiles($dirname=$this->files_folder) {
		echo $dirname;
		if (file_exists($dirname)) {
			$handle = opendir($dirname);
			while (false !== ($file = readdir($handle))) {
				if (is_file($dirname . $file)) {
					echo "<ul>
						  	<li>$file</li>
						  </ul>";
					//array_push($arrayfiles, $file);
				} else if(is_dir($dirname . $file)) {
					echo "<ul>
						  	<li>DIR - $file</li>
						  </ul>";
				}
			}
			$handle = closedir($handle);
		}
		sort($arrayfiles);
		return $arrayfiles;
	}

 } // END
 
 ?>
