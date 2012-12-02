<?
require 'config.php';
require 'classes/class.filemanager.php';
$FM = new esyFileManager;
$getAction = $FM -> take('action');

switch ($getAction) {
	case 'upload' :
		$folder = $FM -> take('folder'); 
		// list of valid extensions, ex. array("jpeg", "xml", "bmp")
		$allowedExtensions = array();
		// max file size in bytes
		$sizeLimit = 10 * 1024 * 1024;
		require 'classes/class.qqfileuploader.php';
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$filename=$uploader->getName();
		if (file_exists($folder.$filename)) {
			$result['error']="Il file \"$filename\" esiste già nella cartella di destinazione";
    		$result['exists']="true";
		} else {
			// Call handleUpload() with the name of the folder, relative to PHP's getcwd()
			$result = $uploader -> handleUpload($folder);
			$result['exists']="false";
		}
		// to pass data through iframe you will need to encode all html tags
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);

		break;
}
?>