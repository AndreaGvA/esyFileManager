<script>
function popimg(){
    window.open('index.php','_blank','width=800, height=600, scrollbars=yes, resizable=yes')
}
 
function urlimg(valoreparametro) { 
	document.getElementById("file").value = valoreparametro; 
} 
</script>
<input type="text" id="file" name="file" ><a href="javascript:popimg()">Directory</a>
