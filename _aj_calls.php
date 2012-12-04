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
 * Ajax Calls Actions
 */

/**
 * Instanzio le classi di base e faccio il take della action
 */
require 'config.php';
require 'classes/class.filemanager.php';
$FM = new esyFileManager;
$getAction = $FM -> take('action');

/**
 * In posto le azioni da eseguire in base alla action ricevuta
 */
switch ($getAction) {
	/**
	 * In caso di upload
	 */
	case 'upload' :
		$folder = $FM -> take('folder');
		// list of valid extensions, ex. array("jpeg", "xml", "bmp")
		$allowedExtensions = array();
		// max file size in bytes
		$sizeLimit = 10 * 1024 * 1024;
		require 'classes/class.qqfileuploader.php';
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$filename = $uploader -> getName();
		if (file_exists($folder . $filename)) {
			$result['error'] = "Il file \"$filename\" esiste già nella cartella di destinazione";
			$result['exists'] = "true";
		} else {
			// Call handleUpload() with the name of the folder, relative to PHP's getcwd()
			$result = $uploader -> handleUpload($folder);
			$result['exists'] = "false";
		}
		// to pass data through iframe you will need to encode all html tags
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		break;
	case 'delete' :
		$file = $FM -> take('file');
		$FM->eliminafiles($file);
		break;
	case 'move' :
		$file = $FM -> take('file');
		$new_file = $FM -> take('new_file');
		if (file_exists($new_file)) {
			$result['errore'] = "Impossibile spostare il file \"$filename\". Nella nella cartella di destinazione esiste già un file con lo stesso nome";
			$result['status'] = "false";
		} else {
			rename($file, $new_file);
			$result['status']="true";
		}
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		break;
	case 'new':
		$folder=$FM->take("folder");
		$nuova_cartella=$FM->new_folder_name($folder, 0);
		mkdir($folder.$nuova_cartella);
		$result['status']="true";
		$result['dirname']=$nuova_cartella; 
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		break;
	case 'jump':
		$dirname=$FM->take("folder");
		echo '<div class="bg">';
		echo "<ul><li rel='' class='dir edit'><div class='filename maindir'>$dirname</div><div class='opendir'></div>";
		$FM -> listFiles(0, $dirname."/");
		echo "</li></ul>";
		echo '</div>';
		break;
		
}
?>