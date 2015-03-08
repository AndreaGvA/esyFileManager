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
 * INCLUDES
 */

require_once "config.php";
require_once "classes/class.filemanager.php";
$FM = new esyFileManager();
$user=get_current_user();
//sleep(5);
$used=$FM->dirSize(FILES_FOLDER);
$quota = exec("cat /tmp/quotas | grep $user | awk '{print $2}'");
$quota = $quota * 1024;
if ($quota=="user") {
	$quota_n=disk_total_space($_SERVER['DOCUMENT_ROOT']);
	$disp_n=disk_free_space($_SERVER['DOCUMENT_ROOT']);
	$used_n=$quota_n-$disp_n;
	$quota_to_print=$FM->bytesToSize($quota_n);
	$used_to_print=$FM->bytesToSize($used_n);
	$disp_to_print=$FM->bytesToSize($disp_n);
} else {
	$quota_to_print=$FM->bytesToSize($quota);
	$used_to_print=$FM->bytesToSize($used);
	$disp_to_print=$FM->bytesToSize($quota-$used);
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="UTF-8">
		<!-- TemplateBeginEditable name="doctitle" -->
		<title>esyFileManager</title>
		<link rel="stylesheet" type="text/css" href="css/jquery.selectBox.css" />
		<link rel="stylesheet" type="text/css" href="css/icons.css" />
		<link rel="stylesheet" type="text/css" href="css/fineuploader.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="js/modernizr.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
		<script src="js/jquery.ui.touch-punch.min.js"></script>
		<script src="js/jquery.fineuploader-3.4.1.min.js"></script>
		<script src="js/jquery.selectBox.min.js"></script>
		<script src="js/purl.js"></script>
		<script>
			var debug = <?php echo DEBUG?>;
			var replacement="<?php echo REPLACE_PATH?>";
			var replace_with="<?php echo REPLACE_WITH?>";
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
				<img src="images/logo.png" width="15%">
			</header>
			<div class="sidebar1">
				<div class="inner-sidebar">
					<span class="small"><?php echo $text["upload_path"]?></span>
				<div class="selectb">
				<select id="upload_folder">
					<option class="main" value="<?php echo FILES_FOLDER ?>"><?php echo substr(FILES_FOLDER, 0, -1); ?></option>
					<?php
					$FM -> listDirs();
					?>
				</select>
				</div>
				<input type="button" class="buttonz" id="crea_cartella" value="<?php echo $text["crea_cartella"]?>" />
				<div class="folderF"></div>
				<div class="uploader"></div>
				
				<!-- end .sidebar1 -->
				<div class="dettagli_file">
					<div class="modal"><?php echo $text["file_details"]?></div> 
					<div class="minimize"><b>_</b></div>
					<div class="det_file"></div>
				</div>
				</div>
				
				
			</div>
			<article class="content">
				<div class="select_folder">
					<select id="sel_fol">
						<option><?php echo $text["nav_dir"]?></option>
						<option class="main" value="<?php echo FILES_FOLDER ?>"><?php echo substr(FILES_FOLDER, 0, -1); ?></option>
						<?php
						$FM -> listDirs();
						?>
					</select>
				</div>
				<div class="trash">
					&nbsp;
				</div>
				<div id="sel"></div>
				<div class="indsd" rel="<?php echo FILES_FOLDER ?>">
					&nbsp;
				</div>
				<div class="order">
					&nbsp;&nbsp;&nbsp;<?php echo $text["nome"]?>
					<?php if ( VIEW_QUOTA ) { ?>
						<span style="float: right; margin-right:10px;"><?php echo $text["dimensioni"]?></span>
					<?php } ?>
				</div>
				<div class="filemanager">
					<div class="bg">
					<?php
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
				<?php if ( VIEW_QUOTA ) { ?> 
				<p>
					<?php echo $text["spazio_disponibile"]?>: <?php  echo $disp_to_print?> - <?php echo  $text["spazio_utilizzato"]?>: <?php echo $used_to_print?> - <?php echo $text["spazio_totale"]?>: <?php echo $quota_to_print?>
				</p>
				<?php } ?>
			</footer>
			
			<!-- end .container -->
		</div>
	</body>
</html>