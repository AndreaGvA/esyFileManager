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
		<link rel="stylesheet" type="text/css" href="css/jquery.selectBox.css" />
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
				&nbsp;
			</header>
			<div class="sidebar1">
				<div class="inner-sidebar">
				<div class="selectb">
				<select id="upload_folder">
					<option class="main" value="<?=FILES_FOLDER ?>"><?=FILES_FOLDER ?></option>
					<?
					$FM -> listDirs();
					?>
				</select>
				</div>
				<input type="button" class="button" id="crea_cartella" value="Crea una cartella" />
				<div class="uploader"></div>
				<!-- end .sidebar1 -->
				</div>
			</div>
			<article class="content">
				<div class="trash">
					&nbsp;
				</div>
				<div class="order">
					&nbsp;&nbsp;&nbsp;Nome
				</div>
				<div class="filemanager">
					<div class="bg">
					<?
					/**
					 * INDEX APP
					 */
					$FM -> init();
					?>
					</div>
				</div>
				<!-- end .content -->
			</article>
			<footer>
				<p>
					&nbsp;
				</p>
			</footer>
			<!-- end .container -->
		</div>
	</body>
</html>