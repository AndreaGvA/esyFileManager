<?php

##########################################################
#                                                        #
#            Script thumbnail by AndreaG                 #
#             andrea.gava@fastwebnet.it                  #
#                                                        #
##########################################################

//Funzione per caricare l'immagine
function LoadJpeg($imgname) {
	$pt = pathinfo($_GET['path']);
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

// imposto gli header
header("Content-Type: image/jpeg");

// carico l'immagine jpg
$img = LoadJpeg($_GET['path']);

// controllo le dimensioni dell'immagine
$fullsize_width = imagesx($img);
$fullsize_height = imagesy($img);

// Assegno la nuova larghezza
$thumb_width = 240;

// Ricavo l'altezza
$thumb_height = floor($fullsize_height / ($fullsize_width / $thumb_width));

// creo l'immagine di base con le nuove dimensioni
$thumb = imagecreatetruecolor($thumb_width, $thumb_height);

// creo copia  dell'immagine ridimensionata
imagecopyresized($thumb, $img, 0, 0, 0, 0, $thumb_width, $thumb_height, $fullsize_width, $fullsize_height);

// invio l'output come immagine Jpg
imagejpeg($thumb);

// libero la memoria
imagedestroy($thumb);
?>
