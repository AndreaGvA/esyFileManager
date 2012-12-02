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
$FM = new esyFileManager();
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<!-- TemplateBeginEditable name="doctitle" -->
		<title>esyFileManager</title>
		<link rel="stylesheet" type="text/css" href="css/fineuploader.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
		<script src="js/jquery.fineuploader-3.0.min.js"></script>
		<script src="js/jquery.FileManager.js"></script>
		<!-- TemplateEndEditable -->
		<!-- TemplateBeginEditable name="head" -->
		<!-- TemplateEndEditable -->
		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>

	<body>
		<div class="container">
			<header>
				<a href="#"><img src="" alt="Insert Logo Here" width="180" height="90" id="Insert_logo" style="background-color: #C6D580; display:block;" /></a>
			</header>
			<div class="sidebar1">
				<select id="upload_folder">
					<option class="main" value="<?=FILES_FOLDER?>"><?=FILES_FOLDER?></option>
					<?
					$FM->listDirs();
					?>
				</select>
				<div class="uploader"></div>
				<!-- end .sidebar1 -->
			</div>
			<article class="content">
				<div class="trash">
					&nbsp;
				</div>
				<div class="filemanager">
					<?
					/**
					 * INDEX APP
					 */
					$FM -> init();
					?>
				</div>
				<!-- end .content -->
			</article>
			<footer>
				<p>
					This footer contains the declaration position:relative; to give Internet Explorer 6 hasLayout for the footer and cause it to clear correctly. If you're not required to support IE6, you may remove it.
				</p>
				<address>
					Address Content
				</address>
			</footer>
			<!-- end .container -->
		</div>
	</body>
</html>