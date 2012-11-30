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

	private $app_folder, $files_folder;

	function esyFileManager() {
		$this -> app_folder = APP_FOLDER;
		$this -> files_folder = FILES_FOLDER;
	}

	/**
	 * listFiles()
	 *
	 * @return Elenca i files e le directory
	 * @author AndreaG
	 */
	function listFiles($livello = 0, $dirname = "") {
		if ($dirname == "")
			$dirname = $this -> files_folder;
		//echo $dirname;
		if (file_exists($dirname)) {
			$handle = opendir($dirname);
			//echo "<br>Apro la dir";
			$n = 0;
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					echo "<ul>";
					echo "<li rel='$dirname'>$file";
					if (is_dir($dirname . $file)) {
						$new_liv = $livello + 1;
						$this -> listFiles($new_liv, $dirname . $file);
					}
					echo "</li>";
					echo "</ul>";
					$n++;
				}
			}
			$handle = closedir($handle);
		}
	}

} // END
 ?>
