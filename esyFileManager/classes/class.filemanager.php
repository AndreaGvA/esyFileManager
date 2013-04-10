<?php
/**
 *
 *
 * @author AndreaG | andrea@smartgap.it
 * @version 0.0.1
 * @copyright SmartGaP s.r.l.
 * @package esyFileManager
 * @site http://www.smartgap.it | http://esyfilemanager.smartgap.it
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
		echo "<ul>
				<li class='path_li'><div class='path_dir'>Path: public</div></li>
				<li rel='".(isset($dirname)?$dirname:"")."' class='dir edit'><div class='filename maindir'>public</div><div class='opendir'></div>";
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
		if ($ext == '3gp') {
			$ico = 'a3gp';
		} else if ($ext == '7z') {
			$ico = 'a7z';
		} else if ($ext == 'ace') {
			$ico = 'ace';
		} else if ($ext == 'aiff') {
			$ico = 'aiff';
		} else if ($ext == 'aif') {
			$ico = 'aif';
		} else if ($ext == 'ai') {
			$ico = 'ai';
		} else if ($ext == 'amr') {
			$ico = 'amr';
		} else if ($ext == 'asf') {
			$ico = 'asf';
		} else if ($ext == 'asx') {
			$ico = 'asx';
		} else if ($ext == 'bat') {
			$ico = 'bat';
		} else if ($ext == 'bin') {
			$ico = 'bin';
		} else if ($ext == 'bmp') {
			$ico = 'bmp';
		} else if ($ext == 'bup') {
			$ico = 'bup';
		} else if ($ext == 'cab') {
			$ico = 'cab';
		} else if ($ext == 'cbr') {
			$ico = 'cbr';
		} else if ($ext == 'cda') {
			$ico = 'cda';
		} else if ($ext == 'cdl') {
			$ico = 'cdl';
		} else if ($ext == 'cdr') {
			$ico = 'cdr';
		} else if ($ext == 'chm') {
			$ico = 'chm';
		} else if ($ext == 'dat') {
			$ico = 'dat';
		} else if ($ext == 'divx') {
			$ico = 'divx';
		} else if ($ext == 'dll') {
			$ico = 'dll';
		} else if ($ext == 'dmg') {
			$ico = 'dmg';
		} else if ($ext == 'doc' || $ext == 'docx') {
			$ico = 'doc';
		} else if ($ext == 'dss') {
			$ico = 'dss';
		} else if ($ext == 'dvf') {
			$ico = 'dvf';
		} else if ($ext == 'dwg') {
			$ico = 'dwg';
		} else if ($ext == 'eml') {
			$ico = 'eml';
		} else if ($ext == 'eps') {
			$ico = 'eps';
		} else if ($ext == 'exe') {
			$ico = 'exe';
		} else if ($ext == 'fla') {
			$ico = 'fla';
		} else if ($ext == 'flv') {
			$ico = 'flv';
		} else if ($ext == 'gif') {
			$ico = 'gif';
		} else if ($ext == 'gz') {
			$ico = 'gz';
		} else if ($ext == 'hqx') {
			$ico = 'hqx';
		} else if ($ext == 'htm') {
			$ico = 'htm';
		} else if ($ext == 'html') {
			$ico = 'html';
		} else if ($ext == 'ifo') {
			$ico = 'ifo';
		} else if ($ext == 'indd') {
			$ico = 'indd';
		} else if ($ext == 'iso') {
			$ico = 'iso';
		} else if ($ext == 'jar') {
			$ico = 'jar';
		} else if ($ext == 'jpeg') {
			$ico = 'jpeg';
		} else if ($ext == 'jpg') {
			$ico = 'jpg';
		} else if ($ext == 'lnk') {
			$ico = 'lnk';
		} else if ($ext == 'log') {
			$ico = 'log';
		} else if ($ext == 'm4a') {
			$ico = 'm4a';
		} else if ($ext == 'm4b') {
			$ico = 'm4b';
		} else if ($ext == 'm4p') {
			$ico = 'm4p';
		} else if ($ext == 'm4v') {
			$ico = 'm4v';
		} else if ($ext == 'mcd') {
			$ico = 'mcd';
		} else if ($ext == 'mdb') {
			$ico = 'mdb';
		} else if ($ext == 'mid') {
			$ico = 'mid';
		} else if ($ext == 'mov') {
			$ico = 'mov';
		} else if ($ext == 'mp2') {
			$ico = 'mp2';
		} else if ($ext == 'mp4') {
			$ico = 'mp4';
		} else if ($ext == 'mpeg') {
			$ico = 'mpeg';
		} else if ($ext == 'mpg') {
			$ico = 'mpg';
		} else if ($ext == 'msi') {
			$ico = 'msi';
		} else if ($ext == 'ogg') {
			$ico = 'ogg';
		} else if ($ext == 'pdf') {
			$ico = 'pdf';
		} else if ($ext == 'png') {
			$ico = 'png';
		} else if ($ext == 'psd') {
			$ico = 'psd';
		} else if ($ext == 'ps') {
			$ico = 'ps';
		} else if ($ext == 'pst') {
			$ico = 'pst';
		} else if ($ext == 'ptb') {
			$ico = 'ptb';
		} else if ($ext == 'pub') {
			$ico = 'pub';
		} else if ($ext == 'qbb') {
			$ico = 'qbb';
		} else if ($ext == 'qbw') {
			$ico = 'qbw';
		} else if ($ext == 'qxd') {
			$ico = 'qxd';
		} else if ($ext == 'ram') {
			$ico = 'ram';
		} else if ($ext == 'rar') {
			$ico = 'rar';
		} else if ($ext == 'rm') {
			$ico = 'rm';
		} else if ($ext == 'rmvb') {
			$ico = 'rmvb';
		} else if ($ext == 'rtf') {
			$ico = 'rtf';
		} else if ($ext == 'sea') {
			$ico = 'sea';
		} else if ($ext == 'ses') {
			$ico = 'ses';
		} else if ($ext == 'sit') {
			$ico = 'sit';
		} else if ($ext == 'sitx') {
			$ico = 'sitx';
		} else if ($ext == 'swf') {
			$ico = 'swf';
		} else if ($ext == 'tgz') {
			$ico = 'tgz';
		} else if ($ext == 'thm') {
			$ico = 'thm';
		} else if ($ext == 'tif') {
			$ico = 'tif';
		} else if ($ext == 'tmp') {
			$ico = 'tmp';
		} else if ($ext == 'ttf') {
			$ico = 'ttf';
		} else if ($ext == 'txt') {
			$ico = 'txt';
		} else if ($ext == 'vcd') {
			$ico = 'vcd';
		} else if ($ext == 'vob') {
			$ico = 'vob';
		} else if ($ext == 'wav') {
			$ico = 'wav';
		} else if ($ext == 'wma') {
			$ico = 'wma';
		} else if ($ext == 'wmv') {
			$ico = 'wmv';
		} else if ($ext == 'wps') {
			$ico = 'wps';
		} else if ($ext == 'xsl' || $ext == 'xslx') {
			$ico = 'xsl';
		} else if ($ext == 'xpi') {
			$ico = 'xpi';
		} else if ($ext == 'zip') {
			$ico = 'zip';
		} else if ($ext == 'ppt' || $ext == 'pps' || $ext == 'pptx' || $ext == 'ppsx') {
			$ico = 'ppt';
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

			if (isset($item) && is_array($item)) {
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
						$nome_da_stampare = "";
						for ($ct = 0; $livello > $ct; $ct++) {
							$nome_da_stampare .= "&nbsp;&nbsp;&nbsp;";
						}
						$nome_da_stampare .= "- " . $item[$n]['file'];
						echo "<option value='" . $item[$n]['dirname'] . $item[$n]['file'] . "/'>" . $nome_da_stampare . "</option> \n";
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
						echo "<li rel='" . $item[$n]['dirname'] . "' class='file edit " . $this -> dropIconClass($item[$n]['file']) . "'><div class='filename'>" . $item[$n]['file'] . "</div><div class='dett_file'>".$this->bytesToSize(filesize($item[$n]['dirname'] . $item[$n]['file']))."</div> \n";
					} else if ($item[$n]['type'] == 0) {
						echo "<li rel='" . $item[$n]['dirname'] . "' class='dir edit'><div class='filename'>" . $item[$n]['file'] . "</div><div class='dett_file'>".$this->bytesToSize($this->dirSize($item[$n]['dirname'] . $item[$n]['file']))."</div><div class='opendir'></div> \n";
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
	function old_eliminafiles($dirname) {
		if (file_exists($dirname) && is_file($dirname)) {
			unlink($dirname);
		} elseif (is_dir($dirname)) {
			$handle = opendir($dirname);
			while (false !== ($file = readdir($handle))) {
				if (is_file($dirname . $file)) {
					unlink($dirname . $file);
				} else if (is_dir($dirname . $file)) {
					echo $file . "<br>";
					if ($file != "." && $file != "..") {
						$this -> eliminafiles($dirname . $file);
					}
				}
			}
			$handle = closedir($handle);
			rmdir($dirname);
		}
	}

	function eliminafiles($dirname) {
		if (is_dir($dirname)) {
			$dir_handle = opendir($dirname);
		} else if (is_file($dirname)) {
			unlink($dirname);
		}
		if (!$dir_handle)
			return false;
		while ($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname . "/" . $file))
					unlink($dirname . "/" . $file);
				else
					$this -> eliminafiles($dirname . '/' . $file);
			}
		}
		closedir($dir_handle);
		rmdir($dirname);
		return true;
	}

	function new_folder_name($folder, $name, $n) {
		if($n==0) {$new_name = "$name";} else {$new_name = "{$name} {$n}";}
		
		if (is_dir($folder . $new_name)) {
			$n++;
			$new_name = $this -> new_folder_name($folder, $new_name, $n);
		}
		return $new_name;
	}

	function bytesToSize($bytes, $precision = 2) {
		$kilobyte = 1024;
		$megabyte = $kilobyte * 1024;
		$gigabyte = $megabyte * 1024;
		$terabyte = $gigabyte * 1024;

		if (($bytes >= 0) && ($bytes < $kilobyte)) {
			return $bytes . ' B';

		} elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
			return round($bytes / $kilobyte, $precision) . ' KB';

		} elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
			return round($bytes / $megabyte, $precision) . ' MB';

		} elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
			return round($bytes / $gigabyte, $precision) . ' GB';

		} elseif ($bytes >= $terabyte) {
			return round($bytes / $terabyte, $precision) . ' TB';
		} else {
			return $bytes . ' B';
		}
	}

	function dirSize($directory) {
		$size = 0;
		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file) {
			$size += $file -> getSize();
		}
		return $size;
	}

} // END
 ?>
