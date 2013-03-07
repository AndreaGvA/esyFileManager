/**
 *
 *
 * @author AndreaG | andrea@smartgap.it
 * @version 0.0.1
 * @copyright SmartGaP s.r.l.
 * @package esyFileManager
 * @site http://www.smartgap.it | http://esyfilemanager.smartgap.it
 */

$(document).ready(function(){
	$(".standalone").click(function(){
		popStandalone();
	});
	$(".pickAfile").click(function(){
		popFile("file");
	});
	$(".pickNo").click(function(){
		popFile("file2");
	});
});