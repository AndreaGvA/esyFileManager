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
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>esyFileManager</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script>
			$(document).ready(function() {
				$('.dir').children("ul").hide();
				$('.dir').children("span").click(function () {
				  $(this).parent().children('ul').toggle();
				});
				 
				$(".edit").children("span").dblclick(function() {
					var a = $(this);
					var i = $(this).children("input");
					var testo = a.html();
					if (testo.indexOf("<input name=") > -1) {
						var testo = i.attr("value");
						a.html(testo);
					} else {
						var uniqid = new Date().getUTCMilliseconds();
						a.html("<input name='" + testo + "' id='" + uniqid + "' value='" + testo + "' />");
						$('#' + uniqid).focus();
						$('#' + uniqid).blur(function() {
							var a = $(this).parent();
							var testo = $(this).attr("value");
							a.html(testo);
						});
					}
				});
			});

		</script>
	</head>

	<body>
		<div class="filemanager">
			<?
			/**
			 * INDEX APP
			 */
			echo "EsyFileManager";
			$FM = new esyFileManager();
			$array = $FM -> listFiles();
			echo "<br><br>";
			print_r($array);
			?>
		</div>
	</body>
</html>
