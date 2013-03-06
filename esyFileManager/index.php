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
$user=get_current_user();
//sleep(5);
$used = exec("cat /tmp/quotas | grep $user | awk '{print $3}'");
$quota = exec("cat /tmp/quotas | grep $user | awk '{print $2}'");
if ($quota=="user") {
	$quota_n=disk_total_space($_SERVER[DOCUMENT_ROOT]);
	$disp_n=disk_free_space($_SERVER[DOCUMENT_ROOT]);
	$used_n=$quota_n-$disp_n;
	$quota_to_print=$FM->bytesToSize($quota_n);
	$used_to_print=$FM->bytesToSize($used_n);
	$disp_to_print=$FM->bytesToSize($disp_n);
} else {
	$quota_to_print=$FM->bytesToSize($quota."000");
	$used_to_print=$FM->bytesToSize($used."000");
	$disp_to_print=$FM->bytesToSize($quota-$used."000");
}
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<!-- TemplateBeginEditable name="doctitle" -->
		<title>esyFileManager</title>
		<link rel="stylesheet" type="text/css" href="css/icons.css" />
		<link rel="stylesheet" type="text/css" href="css/fineuploader.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
		<script src="js/jquery.fineuploader-3.0.min.js"></script>
		<script src="js/purl.js"></script>
		<script>
			var debug = <?=DEBUG?>;
			var replacement="<?=REPLACE_PATH?>";
			var replace_with="<?=REPLACE_WITH?>";
		</script>
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
				<img src="images/logo.png">
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
				<div class="dettagli_file">
					
				</div>
				</div>
				
				
			</div>
			<article class="content">
				<div class="trash">
					&nbsp;
				</div>
				<div class="indsd" rel="<?=FILES_FOLDER ?>">
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
					Spazio Disponibile: <?=$disp_to_print?> - Spazio Utilizzato: <?=$used_to_print?> - Spazio Totale: <?=$quota_to_print?>
				</p>
			</footer>
			<!-- end .container -->
		</div>
	</body>
</html>