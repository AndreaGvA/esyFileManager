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