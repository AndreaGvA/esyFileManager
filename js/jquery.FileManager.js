/**
 *
 *
 * @author AndreaG
 * @version 0.0.1
 * @copyright SmartGaP s.r.l.
 * @package esyFileManager
 */

/**
 * FILE MANAGER BASIC INTERACTIONS
 *
 * Inizializzo le variabili pubbliche
 */

/*
function selectValue(id)
{
    // open popup window and pass field id
    window.open('sku.php?id=' + encodeURIComponent(id),'popuppage',
      'width=400,toolbar=1,resizable=1,scrollbars=yes,height=400,top=100,left=100');
}

function updateValue(id, value)
{
    // this gets called from the popup window and updates the field with a new value
    document.getElementById(id).value = value;
}
function sendValue(value)
{
    var parentId = <?php echo json_encode($_GET['id']); ?>;
    window.opener.updateValue(parentId, value);
    window.close();
}
 */


var move_in, folder, upload_folder;
var hold_timeout = 1000;
var debug = true;
/**
 * Funzione debug
 */
_debug = function(value) {
	if (debug == true) {
		if (console) {
			console.log(value);
		} else {
			alert(value);
		}
	}
}
elimina = function(file) {
	$.ajax({
		type : 'post',
		url : '_aj_calls.php',
		data : {
			'file' : file,
			'action' : 'delete'
		},
		complete : function(data) {
			//$(o.result).html(data);
			_debug('Eliminato: ' + file);
		}
	});
}
rinomina = function(file, new_file) {
	$.ajax({
		type : 'post',
		url : '_aj_calls.php',
		data : {
			'file' : file,
			'new_file' : new_file,
			'action' : 'move'
		},
		complete : function(jqXHR) {
			//$(o.result).html(data);
			var result = $.parseJSON(jqXHR.responseText);
			_debug('Spostato: ' + file);
			return result;
		}
	});
}
/**
 * Funzione per le icone
 */
dropIconClass = function(filename) {
	var ico;
	var ext = filename.substr((filename.lastIndexOf('.') + 1));
	if (ext == 'wmv' || ext == 'mp4' || ext == 'avi' || ext == 'flv') {
		ico = 'video';
	} else if (ext == 'pdf') {
		ico = 'pdf';
	} else if (ext == 'zip') {
		ico = 'zip';
	} else if (ext == 'gif') {
		ico = 'gif';
	} else if (ext == 'jpg') {
		ico = 'jpg';
	} else if (ext == 'bmp' || ext == 'png' || ext == 'tif') {
		ico = 'jpg';
	} else if (ext == 'ppt' || ext == 'pps') {
		ico = 'ppt';
	} else if (ext == 'xls') {
		ico = 'xls';
	} else if (ext == 'mp3' || ext == 'wma' || ext == 'aif' || ext == 'wav') {
		ico = 'ico';
	} else {
		ico = 'ico';
	}
	return ico;
}
/**
 * Funzione per le stringhe
 */
beginsWith = function(needle, haystack) {
	return (haystack.substr(0, needle.length) == needle);
}
/**
 * Funzione dragTree - Permette il drag&drop ecc.
 */
dragTree = function(selector) {
	/**
	 * Rimuovo ovunque la classe selected
	 */
	$('.selected').each(function() {
		$(this).removeClass('selected');
	});
	/**
	 * Aggiungo la classe selected al file selezionato
	 */
	$(selector).addClass('selected');

	/**
	 * Imposto la funzione per il Remname
	 */
	var timeoutId = 0;

	$('.selected').mousedown(function() {
		timeoutId = setTimeout(function() {
			/**
			 * Se il click su selected dura più di hold_timeout
			 * Seleziono .selcted
			 * Seleziono l'input in .selected e ne prendo il testo dividendo estensione e nome file
			 */
			var a = $('.selected');
			var i = a.children("input");
			var testo = a.html();
			/**
			 * Controllo se è una directory e sistemo l'estensione
			 */
			var bool = $('.selected').parent('li').hasClass('dir');
			if (bool == true) {
				var ext = "";
				var filename = testo;
			} else if (bool == false) {
				var ext = "." + testo.substr((testo.lastIndexOf('.') + 1));
				var filename = testo.substr(0, testo.lastIndexOf('.')) || testo;
			}
			/**
			 * Se è già un input ripristino il testo
			 */
			if (testo.indexOf("<input class=") > -1) {
				var testo = i.attr("value");
				a.html(testo);
			} else {
				/**
				 * Altrimenti imposto un id univoco per l'input e lo inserisco attivando il focus
				 */
				var uniqid = new Date().getUTCMilliseconds();
				a.html("<input class='rename' name='" + uniqid + "' id='" + uniqid + "' value='" + filename + "' />");
				$('#' + uniqid).focus();
				/**
				 * Quando esco dall'input inserisco il nuovo testo con l'estensione se è un file, senza se è una cartella
				 */
				$('#' + uniqid).blur(function() {
					var a = $(this).parent();
					var testo = $(this).attr("value");
					var new_filename = testo + ext;
					a.html(new_filename);
				});

			}
		}, hold_timeout);
		/**
		 * Blocco il timeout quando il mouse interrompe il click
		 */
	}).bind('mouseup mouseleave', function() {
		clearTimeout(timeoutId);
	});

	/**
	 * Fine della funzione di rename
	 */

	/**
	 * Funzione per il drag&drop
	 * Rendo l'elemento selezionato draggable
	 */
	$(".selected").draggable({
		appendTo : "body",
		helper : "clone"
	});
	/**
	 * Funzione per il drag&drop nel cestino
	 * Rendo il cetino droppable
	 */
	$('.trash').droppable({
		activeClass : "ui-state-default",
		hoverClass : "trashon",
		accept : ":not(.maindir)",
		drop : function(event, ui) {
			/**
			 * Se è una cartella
			 */
			var bool = $('.selected').parent('li').hasClass('dir');
			var move_from = $('.selected').parent('li').attr('rel');
			var file = $('.selected').html();
			var li_to_move = $('.selected').parent("li");
			if (bool == true) {
				if (confirm("Vuoi eliminare definitivamente la cartella e tutti i files in essa contenuti?")) {
					$('.selected').remove();
					li_to_move.remove();
					_debug("Elimina cartella:" + move_from + file);
					elimina(move_from + file + "/");
				} else
					_debug("Eliminazione cartella annullata: " + move_from + file);
			} else {
				if (confirm("Vuoi eliminare definitivamente il file?")) {
					$('.selected').remove();
					li_to_move.remove();
					/**
					 * Imposto la chiamata aJax per la rimozione del file
					 */
					_debug("Elimina file:" + move_from + file);
					elimina(move_from + file);
				} else
					_debug("Eliminazione file annullata: " + move_from + file);
			}

		}
	})
	/**
	 * Rendo le cartelle droppable
	 * imposto le classi per il drag&drop
	 */
	$('.dir').children('.filename').droppable({
		activeClass : "ui-state-default",
		hoverClass : "drop",
		accept : ":not(.maindir)",
		/**
		 * Quando sto il draggable è sopra a un droppable ne recupero il path
		 */
		over : function(event, ui) {
			move_in = $('.drop').parent('li').attr('rel');
			folder = $('.drop').html();
		},
		/**
		 * onDrop
		 * Blocco la funzione di click per click su .filename (per evitare richieste multiple)
		 * Recupero i l path del file da spostare
		 */
		drop : function(event, ui) {
			$(".edit").find(".filename").unbind("click");
			var move_from = $('.selected').parent('li').attr('rel');
			var file = $('.selected').html();
			/**
			 * Recupero la classe dell'elemento da spostare
			 * Recupero il nome della nuova cartella
			 */
			var new_class = $('.selected').parent('li').attr('class');
			var new_dir = move_in + folder + "/";
			var bool = $('.selected').parent('li').hasClass('dir');
			/**
			 * Se sto spostando una directory
			 * Recupero l'html delle sottodirectory e ne sostituisco il path con quello nuovo
			 * Creo una classe univoca per il nuovo elemento
			 */
			if (bool == true) {
				/**
				 * Controllo che non sto spostando una cartella dentro se stessa
				 */
				file = file + "/";
				var error = beginsWith(move_from + file, move_in + folder);
				if (error == true)
					alert("Non puoi spostare una cartella in se stessa");
				_debug("Non puoi spostare una cartella in se stessa");
				if (error == false) {
					var ul_to_append = $('.selected').parent("li").children('ul').html();
					ul_to_append = ul_to_append.replace(/move_from/g, move_in + folder + "/");
					var uniqid = new Date().getUTCMilliseconds();
					/**
					 * Inserisco l'elemento nella nuova cartella
					 * applico la classe unica per tutti i sottoelementi (serve per hide/show)
					 */
					$(this).parent().children('ul').append("<li class='" + new_class + "' rel='" + new_dir + "'><div class='filename'>" + ui.draggable.text() + "</div><div class='opendir " + uniqid + "'></div><ul style='display:block;'>" + ul_to_append + "</ul></li>");
					$('.' + uniqid).parent().find('.opendir').each(function() {
						$(this).attr('class', 'opendir ' + uniqid);
					});
				}
			} else {
				var error = false;
				/**
				 * Se sto spostando un file
				 * Inserisco l'elemento nella nuova cartella
				 */
				$(this).parent().children('ul').append("<li class='" + new_class + "' rel='" + new_dir + "'><div class='filename'>" + ui.draggable.text() + "</div></li>");
			}
			/**
			 * Seleziono l'elemento da rimuovere
			 * Rimuovo il div selezionato
			 * Rimuovo il blocco spostato
			 * Faccio partire la funzione hide/show sulla classe univoca
			 */
			if (error == false) {

				$.ajax({
					type : 'post',
					url : '_aj_calls.php',
					data : {
						'file' : move_from + file,
						'new_file' : move_in + folder + "/" + file,
						'action' : 'move'
					},
					complete : function(jqXHR) {
						//$(o.result).html(data);
						var result = $.parseJSON(jqXHR.responseText);
						if (result.status == "true") {
							var li_to_move = $('.selected').parent("li");
							$('.selected').remove();
							li_to_move.remove();
							$('.' + uniqid).click(function() {
								var da_nascondere = $(this).parent().children('ul');
								if (da_nascondere.is(':visible')) {
									da_nascondere.hide();
								} else {
									da_nascondere.show();
								}
							});
							_debug('Spostato: ' + file);
						} else {
							alert('Errore: ' + result.errore);
						}

					}
				});

				//_debug("Sposto: " + move_from + file);
				//_debug("Nella cartella: " + move_in + folder + "/" + file);
			}
			/**
			 * Faccio ripartire la funzione di click per click su .filename
			 */
			$(".filename").click(function() {
				dragTree(this);
			});
		}
	});
	/**
	 * Recupero il nome del file selzionato (se non lo sto editando)
	 */
	var selected_folder = $('.selected').parent().attr('rel');
	var selected_file = $(selector).html();
	if (!(selected_file.indexOf("<input class=") > -1)) {
		_debug("Selezionato: " + selected_folder + selected_file);
	}

}
/**
 * Fine Funzione dragTree
 */

/**
 * Quando il DOM è ready
 * Nascondo le cartelle
 * Attivo la funzione hide/show su .opendir
 * Attivo la funzione dragTree su .filename
 */
$(document).ready(function() {

	$('.dir').children("ul").hide();

	$('.opendir').click(function() {
		var da_nascondere = $(this).parent().children('ul');
		if (da_nascondere.is(':visible')) {
			da_nascondere.hide();
		} else {
			da_nascondere.show();
		}
	});

	$(".edit").find(".filename").click(function() {
		dragTree(this);
	});

	/**
	 * Seleziono la cartella per l'upload
	 */
	upload_folder = $('.main').val();
	$("#upload_folder").change(function() {
		upload_folder = $(this).find("option:selected").val();
		_debug("Change:" + upload_folder);
	})
	/**
	 * Creo l'uploader per i files
	 */
	$('.uploader').fineUploader({
		request : {
			endpoint : '_aj_calls.php',
		},
		debug : true
		/**
		 * In caso di errore mi fermo
		 */
	}).on('error', function(event, id, filename, reason) {
		_debug(reason);
	}).on('complete', function(event, id, filename, responseJSON) {
		if (responseJSON.exists == "true") {
			//alert("ERRORE: Già esiste un file con questo nome in questa cartella");
			/*
			setTimeout(function(){
				$('.qq-upload-fail').remove()
			}, 1500);
			*/
			_debug("ERRORE: Già esiste un file con questo nome in questa cartella");
		} else {
			/**
			 * In caso di successo aggiungo l'elemento nella cartella di destinazione
			 */
			$(".dir").each(function(index) {
				var rel_content = $(this).attr('rel');
				var rel_file = $(this).find(".filename").html();
				/**
				 * Blocco dragTree
				 */
				$(".edit").find(".filename").unbind("click");
				if ((rel_content + rel_file + "/") == (upload_folder)) {
					var ico = dropIconClass(filename);
					$(this).children('ul').append('<li rel="' + upload_folder + '" class="file edit ' + ico + '"><div class="filename">' + filename + '</div></li>');
					_debug(rel_content + rel_file + "/");
				}
				/**
				 * Riattivo la funzione dragTree
				 */
				$(".edit").find(".filename").click(function() {
					dragTree(this);
				});
			});
			_debug("upload success!!");
			/*
			setTimeout(function(){
				$('.qq-upload-success').remove()
			}, 1500);
			*/
			
		}
		/**
		 * On Submit faccio il push dei parametri
		 */
	}).on("submit", function() {
		$(this).fineUploader('setParams', {
			'action' : 'upload',
			'folder' : upload_folder
		});
	});
	if($('#up-list').length > 0) {} else {
			$('.qq-upload-list').wrap("<div id='up-list' />");
		}

});
