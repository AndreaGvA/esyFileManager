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
 require_once "classes/class.filemanager.php"
 
/**
 * INDEX APP
 */
 
 $FM=new esyFileManager;
 $FM->listFiles();
 ?>