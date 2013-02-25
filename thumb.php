<?php

##########################################################
#                                                        #
#            Script thumbnail by AndreaG                 #
#             andrea.gava@fastwebnet.it                  #
#                                                        #
##########################################################

//Funzione per caricare l'immagine
function LoadJpeg($imgname) {
	$pt = pathinfo($imgname);
	$ext = $pt['extension'];
	if ($ext == "jpg" || $ext == "jpeg") {
		$im = @imagecreatefromjpeg($imgname);
		/* Provo ad aprire l'immagine */
	} else if ($ext == "png") {
		$im = @imagecreatefrompng($imgname);
		//Prelevo l'immagine da dove l'ho salvata pocanzi
	} else if ($ext == "gif") {
		$im = @imagecreatefromgif($imgname);
		//Prelevo l'immagine da dove l'ho salvata pocanzi
	}
	if (!$im) {/* Controllo se nriesce a caricare l'immagine */
		$im = imagecreatetruecolor(150, 30);
		/* Creo un'immagine nera */
		$bgc = imagecolorallocate($im, 255, 255, 255);
		/* Imposto il colore di background */
		$tc = imagecolorallocate($im, 0, 0, 0);
		/* Imposto l'altro colore */
		imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
		/* creo un rettangolo pieno */
		/* Output messaggio di errore se l'immagine non viene caricata */
		imagestring($im, 1, 5, 5, "Error loading $imgname", $tc);
	}
	/* Output dell'immagine */
	return $im;
}

##########################################################

// carico l'immagine jpg
$img = LoadJpeg($_GET['path']);

// controllo le dimensioni dell'immagine
$fullsize_width = imagesx($img);
$fullsize_height = imagesy($img);

// Assegno la dimensione massima per il resize
$max_dim = 240;
// Assegno il colore di sfondo
$bg = '#ffffff';

//Trovo la dimensione per il thumb
if ($fullsize_width >= $fullsize_height) {
	$small_width = $max_dim;
	//dimensione della larghezza l'altezza viene fatta in proporzione
	$small_height = floor($fullsize_height / ($fullsize_width / $small_width));
	$dist_height = ($max_dim - $small_height) / 2;
	$dist_width = 0;
} else {
	$small_height = $max_dim;
	$small_width = floor($fullsize_width / ($fullsize_height / $small_height));
	$dist_width = ($max_dim - $small_width) / 2;
	$dist_height = 0;
}
$small = imagecreatetruecolor($max_dim, $max_dim);
$col = (sscanf($bg, '#%2x%2x%2x'));
$bianco = imageColorAllocate($small, $col[0], $col[1], $col[2]);

imagefilledrectangle($small, 0, 0, $max_dim, $max_dim, $bianco);
imagecopyresampled($small, $img, $dist_width, $dist_height, 0, 0, $small_width, $small_height, $fullsize_width, $fullsize_height);

// invio l'output come immagine Jpg
imagejpeg($small);

// libero la memoria
imagedestroy($small);
?>
