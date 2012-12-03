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

	private $files_folder;

	function esyFileManager() {
		$this -> files_folder = FILES_FOLDER;
	}

	function init() {
		echo "<ul><li rel='$dirname' class='dir edit'><div class='filename maindir'>public</div><div class='opendir'></div>";
		$this -> listFiles();
		echo "</li></ul>";
	}

	function take($var) {
		$tmp = '';
		if (isset($_GET[$var]))
			$tmp = $_GET[$var];
		if ($tmp == '') {
			if (isset($_POST[$var]))
				$tmp = $_POST[$var];
		}
		return $tmp;
	}

	private function dropIconClass($filename) {
		$fileInfo = pathinfo($filename);
		$ext = $fileInfo['extension'];
		if ($ext == 'wmv' || $ext == 'mp4' || $ext == 'avi' || $ext == 'flv') {
			$ico = 'video';
		} else if ($ext == 'pdf') {
			$ico = 'pdf';
		} else if ($ext == 'zip') {
			$ico = 'zip';
		} else if ($ext == 'gif') {
			$ico = 'gif';
		} else if ($ext == 'jpg') {
			$ico = 'jpg';
		} else if ($ext == 'bmp' || $ext == 'png' || $ext == 'tif') {
			$ico = 'jpg';
		} else if ($ext == 'ppt' || $ext == 'pps') {
			$ico = 'ppt';
		} else if ($ext == 'xls') {
			$ico = 'xls';
		} else if ($ext == 'mp3' || $ext == 'wma' || $ext == 'aif' || $ext == 'wav') {
			$ico = 'ico';
		} else {
			$ico = 'ico';
		}
		return $ico;
	}

	function listDirs($livello = 0, $dirname = "") {
		/**
		 * listDirs()
		 *
		 * @return Elenca le option delle directory
		 * @author AndreaG
		 */
		if ($dirname == "")
			$dirname = $this -> files_folder;
		//echo $dirname;

		if (file_exists($dirname)) {

			$handle = opendir($dirname);
			//echo "<br>Apro la dir";
			$n = 0;
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if (is_dir($dirname . $file)) {
						$item[$n]['type'] = 0;
						$item[$n]['dirname'] = $dirname;
						$item[$n]['file'] = $file;
					}
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
					if ($item[$n]['type'] == 0) {
						echo "<option value='" . $item[$n]['dirname'] . $item[$n]['file'] . "/'>" . $item[$n]['dirname'] . $item[$n]['file'] . "</option> \n";
						$new_liv = $livello + 1;
						$this -> listDirs($new_liv, $item[$n]['dirname'] . $item[$n]['file'] . "/");
					}
				}
			}

			$handle = closedir($handle);

		}

	}

	/**
	 * listFiles()
	 *
	 * @return Elenca i files e le directory
	 * @author AndreaG
	 */
	private function listFiles($livello = 0, $dirname = "") {
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
						echo "<li rel='" . $item[$n]['dirname'] . "' class='file edit " . $this -> dropIconClass($item[$n]['file']) . "'><div class='filename'>" . $item[$n]['file'] . "</div> \n";
					} else if ($item[$n]['type'] == 0) {
						echo "<li rel='" . $item[$n]['dirname'] . "' class='dir edit'><div class='filename'>" . $item[$n]['file'] . "</div><div class='opendir'></div> \n";
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
	
	/**
	 * eliminafiles($dirname)
	 *
	 * @return Elimina files ricorsivamente in una cartella e poi elimina la cartella
	 * @author AndreaG
	 */
	function eliminafiles($dirname) {
		if (file_exists($dirname) && is_file($dirname)) {
			unlink($dirname);
		} elseif (is_dir($dirname)) {
			$handle = opendir($dirname);
			while (false !== ($file = readdir($handle))) {
				if (is_file($dirname . $file)) {
					unlink($dirname . $file);
				}
			}
			$handle = closedir($handle);
			rmdir($dirname);
		}
	}

} // END
 ?>
