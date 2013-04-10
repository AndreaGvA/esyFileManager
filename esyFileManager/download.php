<?php
     //BUILD THE FILE INFORMATION
     $file = $_GET['file'];
 
     //CREATE/OUTPUT THE HEADER
     header("Content-type: application/force-download");
     header("Content-Transfer-Encoding: Binary");
     header("Content-length: ".filesize($file));
     header("Content-disposition: attachment; filename=\"".basename($file)."\"");
     readfile($file);
?>