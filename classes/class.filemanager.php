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
			echo "<ul> \n";
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if (is_file($dirname . $file)) {
						$item[$n]['type'] = 1;
					} else {
						$item[]['type'] = 0;
					}

					$item[$n]['dirname'] = $dirname;
					$item[$n]['file'] = $file;
					//echo "</li> \n";
					$n++;
				}
			}

			if (is_array($item)) {
				// Obtain a list of columns
				foreach ($item as $key => $row) {
					$file[$key] = $row['file'];
					$type[$key] = $row['type'];
				}

				// Sort the data with volume descending, edition ascending
				// Add $data as the last parameter, to sort by the common key
				array_multisort($type, SORT_ASC, $file, SORT_ASC, $item);

				$num = count($item);
				for ($n = 0; $n < $num; $n++) {
					//echo $item[$n]['type']." ".$item[$n]['file']."<br>";
					if ($item[$n]['type'] == 1) {
						echo "<li rel='" . $item[$n]['dirname'] . "' class='file edit'><span>" . $item[$n]['file'] . "</span> \n";
					} else if ($item[$n]['type'] == 0) {
						echo "<li rel='" . $item[$n]['dirname'] . "' class='dir edit'><span>" . $item[$n]['file'] . "</span> \n";
						$new_liv = $livello + 1;
						$this -> listFiles($new_liv, $item[$n]['dirname'] . $item[$n]['file'] . "/");
					}
					echo "</li>";
				}
			}

			$handle = closedir($handle);
			echo "</ul>";
		}
	}

} // END
 ?>
