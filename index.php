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
		<!-- TemplateBeginEditable name="doctitle" -->
		<title>esyFileManager</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script>
			$(document).ready(function() {
				$('.dir').children("ul").hide();
				$('.dir').children("span").click(function() {
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
				<ul class="nav">
					<li>
						<a href="#">Link one</a>
					</li>
					<li>
						<a href="#">Link two</a>
					</li>
					<li>
						<a href="#">Link three</a>
					</li>
					<li>
						<a href="#">Link four</a>
					</li>
				</ul>
				<aside>
					<p>
						The above links demonstrate a basic navigational structure using an unordered list styled with CSS. Use this as a starting point and modify the properties to produce your own unique look. If you require flyout menus, create your own using a Spry menu, a menu widget from Adobe's Exchange or a variety of other javascript or CSS solutions.
					</p>
					<p>
						If you would like the navigation along the top, simply move the ul to the top of the page and recreate the styling.
					</p>
				</aside>
				<!-- end .sidebar1 -->
			</div>
			<article class="content">
				<h1>Instructions</h1>
				<div class="filemanager">
					<?
					/**
					 * INDEX APP
					 */
					echo "EsyFileManager";
					$FM = new esyFileManager();
					$array = $FM -> listFiles();
					echo "
					<br>
					<br>
					";
					print_r($array);
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