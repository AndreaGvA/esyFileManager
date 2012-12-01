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
 * INCLUDES
 */
 
 require_once "config.php";
 require_once "classes/class.filemanager.php";
 
/**
 * INDEX APP
 */
 echo "EsyFileManager";
 $FM = new esyFileManager();
 $array=$FM->listFiles();
 echo "<br><br>";
 print_r($array);
 ?>