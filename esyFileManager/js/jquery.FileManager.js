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
 window.opener.urlimg(value);
 window.close();
 }
 */

var utilizzo=$.url().param("u");
var move_in, folder, upload_folder, mfdr;
var hold_timeout = 1000;

$.fn.watch = function(props, callback, timeout) {
	if (!timeout)
		timeout = 10;
	return this.each(function() {
		var el = $(this), func = function() {
			__check.call(this, el)
		}, data = {
			props : props.split(","),
			func : callback,
			vals : []
		};
		$.each(data.props, function(i) {
			data.vals[i] = el.css(data.props[i]);
		});
		el.data(data);
		if ( typeof (this.onpropertychange) == "object") {
			el.bind("propertychange", callback);
		} else if ($.browser.mozilla) {
			el.bind("DOMAttrModified", callback);
		} else {
			setInterval(func, timeout);
		}
	});
	function __check(el) {
		var data = el.data(), changed = false, temp = "";
		for (var i = 0; i < data.props.length; i++) {
			temp = el.css(data.props[i]);
			if (data.vals[i] != temp) {
				data.vals[i] = temp;
				changed = true;
				break;
			}
		}
		if (changed && data.func) {
			data.func.call(el, data);
		}
	}

}

jQuery.fn.selectText = function() {
	var doc = document;
	var element = this[0];
	console.log(this, element);
	if (doc.body.createTextRange) {
		var range = document.body.createTextRange();
		range.moveToElementText(element);
		range.select();
	} else if (window.getSelection) {
		var selection = window.getSelection();
		var range = document.createRange();
		range.selectNodeContents(element);
		selection.removeAllRanges();
		selection.addRange(range);
	}
};

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
sposta = function(file, new_file) {
	$.ajax({
		type : 'post',
		url : '_aj_calls.php',
		data : {
			'file' : file,
			'new_file' : new_file,
			'action' : 'move'
		},
		complete : function(jqXHR) {
			var result = $.parseJSON(jqXHR.responseText);
			if (result.status == "true") {
				_debug('Spostato: ' + file);
			} else {
				alert('Errore: ' + result.errore);
			}
		}
	});
}
getUrlParam = function(paramName) {
	var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i');
	var match = window.location.search.match(reParam);

	return (match && match.length > 1) ? match[1] : '';
}
trova_soposta = function() {
	upload_folder = $('.main').val();
	$("#upload_folder").change(function() {
		upload_folder = $(this).find("option:selected").val();
		_debug("Change:" + upload_folder);
	})
}
create_folder = function(folder) {
	$.ajax({
		type : 'post',
		url : '_aj_calls.php',
		data : {
			'folder' : folder,
			'action' : 'new'
		},
		complete : function(jqXHR) {
			var result = $.parseJSON(jqXHR.responseText);
			var uniqid = new Date().getUTCMilliseconds();
			if (result.status == "true") {
				new_folder_element = '<li rel="' + folder + '" class="dir edit"><div class="filename ui-draggable ui-droppable">' + result.dirname + '</div><div class="opendir ' + uniqid + '"/><ul style="display: block; "/></li>';
				$('.dir').each(function() {
					var attr = $(this).attr('rel');
					var nome = $(this).find('.filename').html();
					if (attr + nome + "/" == folder) {
						$(".edit").find(".filename").unbind("click");
						$(this).children("ul").append(new_folder_element);
						$('.' + uniqid).click(function() {
							var da_nascondere = $(this).parent().children('ul');
							if (da_nascondere.is(':visible')) {
								da_nascondere.hide();
							} else {
								da_nascondere.show();
							}
						});
						$(".edit").find(".filename").click(function(e) {
							dragTree(this, e);
						});
						var dire = $(".main").val();
						dire = dire.substring(0, dire.length - 1);
						load_select(dire);
						_debug('Creata: ' + folder + result.dirname);
					}
				});

			} else {
				alert('Errore: ' + result.errore);
			}
		}
	});
}
select_file = function() {
	$(".file").find(".filename").on("dblclick", function(e) {
		var path1 = $(this).parent(".edit").attr("rel");
		var path2 = $(this).html();
		var fileUrl = path1 + path2;
		fileUrl = fileUrl.replace(replacement, replace_with);
		if (utilizzo == 1) {
			var textarea=$.url().param("cl");
			window.opener.urlimg(fileUrl, textarea);
			window.close();
		} else if (utilizzo == 2) {
			// Helper function to get parameters from the query string.
			var funcNum = getUrlParam('CKEditorFuncNum');
			//fileUrl = fileUrl.replace(replacement, replace_with);
			window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
			window.close();
		} else {};

	});
}
jump = function(dir) {
	select_file();
	$(".edit").find(".filename").on("dblclick", function(e) {
		var check = $(this).hasClass('maindir');
		if (check == false) {
			var bool = $(this).parent("li").hasClass("dir");
			if (bool == true) {
				if (dir != "" || dir != undefined) {
					dirn = mfdr;
				} else {
					dirn = dir;
				}
				$(".filemanager").load('_aj_calls.php', {
					'folder' : dirn,
					'action' : 'jump'
				}, function() {
					$('.opendir').click(function() {
						var da_nascondere = $(this).parent().children('ul');
						if (da_nascondere.is(':visible')) {
							da_nascondere.hide();
						} else {
							da_nascondere.show();
						}
					});
					load_select(dirn);
					$(".edit").find(".filename").click(function(e) {
						dragTree(this, e);
					});
					jump();
				});
				//alert(mfdr);
			}
		}
	});
}
load_select = function(folder) {
	$('.selectb').load('_aj_calls.php', {
		'action' : "select",
		"folder" : folder
	}, function() {
		trova_soposta();
	});
	_debug("upload della select");
}
/**
 * Funzione per le icone
 */
dropIconClass = function(filename) {
	var ico;
	var ext = filename.substr((filename.lastIndexOf('.') + 1));
	if (ext == '3gp') {
		ico = 'a3gp';
	} else if (ext == '7z') {
		ico = 'a7z';
	} else if (ext == 'ace') {
		ico = 'ace';
	} else if (ext == 'aiff') {
		ico = 'aiff';
	} else if (ext == 'aif') {
		ico = 'aif';
	} else if (ext == 'ai') {
		ico = 'ai';
	} else if (ext == 'amr') {
		ico = 'amr';
	} else if (ext == 'asf') {
		ico = 'asf';
	} else if (ext == 'asx') {
		ico = 'asx';
	} else if (ext == 'bat') {
		ico = 'bat';
	} else if (ext == 'bin') {
		ico = 'bin';
	} else if (ext == 'bmp') {
		ico = 'bmp';
	} else if (ext == 'bup') {
		ico = 'bup';
	} else if (ext == 'cab') {
		ico = 'cab';
	} else if (ext == 'cbr') {
		ico = 'cbr';
	} else if (ext == 'cda') {
		ico = 'cda';
	} else if (ext == 'cdl') {
		ico = 'cdl';
	} else if (ext == 'cdr') {
		ico = 'cdr';
	} else if (ext == 'chm') {
		ico = 'chm';
	} else if (ext == 'dat') {
		ico = 'dat';
	} else if (ext == 'divx') {
		ico = 'divx';
	} else if (ext == 'dll') {
		ico = 'dll';
	} else if (ext == 'dmg') {
		ico = 'dmg';
	} else if (ext == 'doc' || ext == 'docx') {
		ico = 'doc';
	} else if (ext == 'dss') {
		ico = 'dss';
	} else if (ext == 'dvf') {
		ico = 'dvf';
	} else if (ext == 'dwg') {
		ico = 'dwg';
	} else if (ext == 'eml') {
		ico = 'eml';
	} else if (ext == 'eps') {
		ico = 'eps';
	} else if (ext == 'exe') {
		ico = 'exe';
	} else if (ext == 'fla') {
		ico = 'fla';
	} else if (ext == 'flv') {
		ico = 'flv';
	} else if (ext == 'gif') {
		ico = 'gif';
	} else if (ext == 'gz') {
		ico = 'gz';
	} else if (ext == 'hqx') {
		ico = 'hqx';
	} else if (ext == 'htm') {
		ico = 'htm';
	} else if (ext == 'html') {
		ico = 'html';
	} else if (ext == 'ifo') {
		ico = 'ifo';
	} else if (ext == 'indd') {
		ico = 'indd';
	} else if (ext == 'iso') {
		ico = 'iso';
	} else if (ext == 'jar') {
		ico = 'jar';
	} else if (ext == 'jpeg') {
		ico = 'jpeg';
	} else if (ext == 'jpg') {
		ico = 'jpg';
	} else if (ext == 'lnk') {
		ico = 'lnk';
	} else if (ext == 'log') {
		ico = 'log';
	} else if (ext == 'm4a') {
		ico = 'm4a';
	} else if (ext == 'm4b') {
		ico = 'm4b';
	} else if (ext == 'm4p') {
		ico = 'm4p';
	} else if (ext == 'm4v') {
		ico = 'm4v';
	} else if (ext == 'mcd') {
		ico = 'mcd';
	} else if (ext == 'mdb') {
		ico = 'mdb';
	} else if (ext == 'mid') {
		ico = 'mid';
	} else if (ext == 'mov') {
		ico = 'mov';
	} else if (ext == 'mp2') {
		ico = 'mp2';
	} else if (ext == 'mp4') {
		ico = 'mp4';
	} else if (ext == 'mpeg') {
		ico = 'mpeg';
	} else if (ext == 'mpg') {
		ico = 'mpg';
	} else if (ext == 'msi') {
		ico = 'msi';
	} else if (ext == 'ogg') {
		ico = 'ogg';
	} else if (ext == 'pdf') {
		ico = 'pdf';
	} else if (ext == 'png') {
		ico = 'png';
	} else if (ext == 'psd') {
		ico = 'psd';
	} else if (ext == 'ps') {
		ico = 'ps';
	} else if (ext == 'pst') {
		ico = 'pst';
	} else if (ext == 'ptb') {
		ico = 'ptb';
	} else if (ext == 'pub') {
		ico = 'pub';
	} else if (ext == 'qbb') {
		ico = 'qbb';
	} else if (ext == 'qbw') {
		ico = 'qbw';
	} else if (ext == 'qxd') {
		ico = 'qxd';
	} else if (ext == 'ram') {
		ico = 'ram';
	} else if (ext == 'rar') {
		ico = 'rar';
	} else if (ext == 'rm') {
		ico = 'rm';
	} else if (ext == 'rmvb') {
		ico = 'rmvb';
	} else if (ext == 'rtf') {
		ico = 'rtf';
	} else if (ext == 'sea') {
		ico = 'sea';
	} else if (ext == 'ses') {
		ico = 'ses';
	} else if (ext == 'sit') {
		ico = 'sit';
	} else if (ext == 'sitx') {
		ico = 'sitx';
	} else if (ext == 'swf') {
		ico = 'swf';
	} else if (ext == 'tgz') {
		ico = 'tgz';
	} else if (ext == 'thm') {
		ico = 'thm';
	} else if (ext == 'tif') {
		ico = 'tif';
	} else if (ext == 'tmp') {
		ico = 'tmp';
	} else if (ext == 'ttf') {
		ico = 'ttf';
	} else if (ext == 'txt') {
		ico = 'txt';
	} else if (ext == 'vcd') {
		ico = 'vcd';
	} else if (ext == 'vob') {
		ico = 'vob';
	} else if (ext == 'wav') {
		ico = 'wav';
	} else if (ext == 'wma') {
		ico = 'wma';
	} else if (ext == 'wmv') {
		ico = 'wmv';
	} else if (ext == 'wps') {
		ico = 'wps';
	} else if (ext == 'xsl' || ext == 'xslx') {
		ico = 'xsl';
	} else if (ext == 'xpi') {
		ico = 'xpi';
	} else if (ext == 'zip') {
		ico = 'zip';
	} else if (ext == 'ppt' || ext == 'pps' || ext == 'pptx' || ext == 'ppsx') {
		ico = 'ppt';
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
dragTree = function(selector, event) {
	/**
	 * Rimuovo ovunque la classe selected
	 */
	if (!(event.ctrlKey || event.altKey || event.shiftKey || event.metaKey)) {
		$('.selected').each(function() {
			$(this).removeClass('selected');
		});
	}
	/**
	 * Aggiungo la classe selected al file selezionato
	 */
	$(selector).toggleClass('selected');

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
			var folder_w = a.parent("li").attr('rel');
			var i = a.children("input");
			var filename = a.html();
			/**
			 * Altrimenti imposto un id univoco per l'input e lo inserisco attivando il focus
			 */
			var uniqid = new Date().getUTCMilliseconds();
			a.html(filename);
			a.attr("contenteditable", true);
			if ( typeof salva_rinomina !== 'undefined') {
				salva_rinomina.unbind();
			}
			a.selectText();
			a.focus();
			setTimeout(function() {
				salva_rinomina = $('body').one("click", function(e) {

					if (filename == a.html() || a.html() == "") {
						a.html(filename);
						_debug("non è cambiato");
						return;
					} else {

						var testob = a.html();
						var new_filename = testob.replace(/ /g, "_");
						sposta(folder_w + filename, folder_w + new_filename);
						a.html(new_filename);
						a.removeAttr('contenteditable').blur();
						_debug("salvo il nuovo nome");
					}

				});

			}, 1000);

			/* BUGGY CODE
			a.blur(function(){
			a.html(filename+ext);
			a.removeAttr('contenteditable').blur();
			_debug("fuori senza salvare");
			});
			*/
			/**
			 * Quando esco dall'input inserisco il nuovo testo con l'estensione se è un file, senza se è una cartella
			 */

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
			if (confirm("Vuoi eliminare definitivamente tutti i file selezionati?")) {
				$('.selected').each(function() {
					var bool = $(this).parent('li').hasClass('dir');
					var move_from = $(this).parent('li').attr('rel');
					if (move_from != undefined) {
						var file = $(this).html();
						var li_to_move = $(this).parent("li");
						if (bool == true) {
							$(this).remove();
							li_to_move.remove();
							_debug("Elimina cartella:" + move_from + file);
							elimina(move_from + file + "/");
							var dire = $(".main").val();
							dire = dire.substring(0, dire.length - 1);
							load_select(dire);
						} else {
							$(this).remove();
							li_to_move.remove();
							/**
							 * Imposto la chiamata aJax per la rimozione del file
							 */
							_debug("Elimina file:" + move_from + file);
							elimina(move_from + file);
						}
					}
				});
			} else
				_debug("Eliminazione file annullata: " + move_from + file);
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
			var dropfolder = $(this);
			$(".edit").find(".filename").unbind("click");
			$('.selected').each(function() {
				var move_from = $(this).parent('li').attr('rel');
				if (move_from != undefined) {
					var file = $(this).html();
					/**
					 * Recupero la classe dell'elemento da spostare
					 * Recupero il nome della nuova cartella
					 */
					var new_class = $(this).parent('li').attr('class');
					var new_dir = move_in + folder + "/";
					var bool = $(this).parent('li').hasClass('dir');
					/**
					 * Se sto spostando una directory
					 * Recupero l'html delle sottodirectory e ne sostituisco il path con quello nuovo
					 * Creo una classe univoca per il nuovo elemento
					 */
					$('.ui-draggable-dragging').remove();
					if (bool == true) {
						/**
						 * Controllo che non sto spostando una cartella dentro se stessa
						 */
						filet = file;
						file = file + "/";
						var error = beginsWith(move_from + file, move_in + folder);
						if (error == true) {
							alert("Non puoi spostare una cartella in se stessa");
							_debug("Non puoi spostare una cartella in se stessa");
						}
						if (error == false) {
							var ul_to_append = $(this).parent("li").children('ul').html();
							ul_to_append = ul_to_append.replace(/move_from/g, move_in + folder + "/");
							var uniqid = new Date().getUTCMilliseconds();
							/**
							 * Inserisco l'elemento nella nuova cartella
							 * applico la classe unica per tutti i sottoelementi (serve per hide/show)
							 */
							dropfolder.parent().children('ul').append("<li class='" + new_class + "' rel='" + new_dir + "'><div class='filename'>" + filet + "</div><div class='opendir " + uniqid + "'></div><ul style='display:block;'>" + ul_to_append + "</ul></li>");
							$('.' + uniqid).parent().find('.opendir').each(function() {
								$(this).attr('class', 'opendir ' + uniqid);
							});
							select_file();
						}
					} else {
						var error = false;
						/**
						 * Se sto spostando un file
						 * Inserisco l'elemento nella nuova cartella
						 */
						dropfolder.parent().children('ul').append("<li class='" + new_class + "' rel='" + new_dir + "'><div class='filename'>" + file + "</div></li>");
						select_file();
					}
					/**
					 * Seleziono l'elemento da rimuovere
					 * Rimuovo il div selezionato
					 * Rimuovo il blocco spostato
					 * Faccio partire la funzione hide/show sulla classe univoca
					 */
					if (error == false) {
						sposta(move_from + file, move_in + folder + "/" + file);

						var li_to_move = $(this).parent("li");
						$(this).remove();
						li_to_move.remove();
						$('.' + uniqid).click(function() {
							var da_nascondere = $(this).parent().children('ul');
							if (da_nascondere.is(':visible')) {
								da_nascondere.hide();
							} else {
								da_nascondere.show();
							}
						});
						var dire = $(".main").val();
						dire = dire.substring(0, dire.length - 1);
						load_select(dire);
						_debug("Sposto: " + move_from + file);
						_debug("Nella cartella: " + move_in + folder + "/" + file);
					}
				}

			});

			/**
			 * Faccio ripartire la funzione di click per click su .filename
			 */
			$(".filename").click(function(e) {
				dragTree(this, e);
			});
		}
	});
	/**
	 * Recupero il nome del file selzionato (se non lo sto editando)
	 */
	var selected_folder = $('.selected').parent().attr('rel');
	var selected_file = $(selector).html();
	if (!(selected_file.indexOf("<input class=") > -1)) {
		mfdr = selected_folder + selected_file;
		_debug("Selezionato: " + selected_folder + selected_file);
		$('.dettagli_file').load("_aj_calls.php?action=fileinfo&path=" + selected_folder + selected_file, function() {
			$('#reload').on("click", function() {
				crt = $(this).attr("rel");
				crt = crt.substring(0, crt.length - 1);
				$(".filemanager").load('_aj_calls.php', {
					'folder' : crt,
					'action' : 'jump'
				}, function() {
					$('.opendir').click(function() {
						var da_nascondere = $(this).parent().children('ul');
						if (da_nascondere.is(':visible')) {
							da_nascondere.hide();
						} else {
							da_nascondere.show();
						}
					});
					load_select(crt);
					$(".edit").find(".filename").click(function(e) {
						dragTree(this, e);
					});
					jump();
				});
			});
		});
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

	$(".edit").find(".filename").click(function(e) {
		dragTree(this, e);
	});

	jump();
	$('.indsd').on("click", function() {
		crt = $(this).attr("rel");
		crt = crt.substring(0, crt.length - 1);
		$(".filemanager").load('_aj_calls.php', {
			'folder' : crt,
			'action' : 'jump'
		}, function() {
			$('.opendir').click(function() {
				var da_nascondere = $(this).parent().children('ul');
				if (da_nascondere.is(':visible')) {
					da_nascondere.hide();
				} else {
					da_nascondere.show();
				}
			});
			load_select(crt);
			$(".edit").find(".filename").click(function(e) {
				dragTree(this, e);
			});
			jump();
		});
	});

	/**
	 * Seleziono la cartella per l'upload
	 */
	trova_soposta();
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
					filename = filename.replace(/ /g, "_");
					var ico = dropIconClass(filename);
					$(this).children('ul').append('<li rel="' + upload_folder + '" class="file edit ' + ico + '"><div class="filename">' + filename + '</div></li>');
					select_file();
					_debug(rel_content + rel_file + "/");
				}
				/**
				 * Riattivo la funzione dragTree
				 */
				$(".edit").find(".filename").click(function(ev) {
					dragTree(this, ev);
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
	if ($('#up-list').length > 0) {
	} else {
		$('.qq-upload-list').wrap("<div id='up-list' />");
	}

	/**
	 * Script per la creazione delle cartelle
	 */
	$("#crea_cartella").click(function() {
		create_folder(upload_folder);
		_debug("Crea cartella in: " + upload_folder);
	})
	/**
	 * Un po di js per il template
	 */
	var height = $(document).height();
	var cont_height = height - 80 - 40 - 20;
	$(".filemanager").height(cont_height - 15);
	$(".inner-sidebar").height(cont_height);

});
$(window).resize(function() {
	var height = $(this).height();
	var cont_height = height - 80 - 40 - 20;
	$(".filemanager").height(cont_height - 15);
	$(".inner-sidebar").height(cont_height);
});
