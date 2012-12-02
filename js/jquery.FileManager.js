var move_in;
var folder;

function dragTree(selector) {

	$('.selected').each(function() {
		$(this).removeClass('selected');
	});

	$(selector).addClass('selected');
	// FUNZIONE PER IL RENAME

	var timeoutId = 0;

	$('.selected').mousedown(function() {
		timeoutId = setTimeout(function() {
			var a = $('.selected');
			var i = a.children("input");
			var testo = a.html();
			var ext = testo.substr((testo.lastIndexOf('.') + 1));
			var filename = testo.substr(0, testo.lastIndexOf('.')) || testo;
			if (testo.indexOf("<input class=") > -1) {
				var testo = i.attr("value");
				a.html(testo);
			} else {
				var uniqid = new Date().getUTCMilliseconds();
				a.html("<input class='rename' name='" + uniqid + "' id='" + uniqid + "' value='" + filename + "' />");
				$('#' + uniqid).focus();
				$('#' + uniqid).blur(function() {
					var a = $(this).parent();
					var testo = $(this).attr("value");
					if (ext != testo) {
						new_filename = testo + "." + ext;
					} else {
						new_filename = testo;
					}
					a.html(new_filename);
				});

			}
		}, 1000);
	}).bind('mouseup mouseleave', function() {
		clearTimeout(timeoutId);
	});

	// END RENAME

	// DRAG & DROP
	$(".selected").draggable({
		appendTo : "body", helper : "clone"
	});
	$('.dir').children('.filename').droppable({
		activeClass : "ui-state-default", hoverClass : "drop", accept : ":not(.ui-sortable-helper)", over : function(event, ui) {
			move_in = $('.drop').parent('li').attr('rel');
			folder = $('.drop').html();
		}, drop : function(event, ui) {
			$(".edit").find(".filename").unbind("click");
			var move_from = $('.selected').parent('li').attr('rel');
			var file = $('.selected').html();
			console.log(move_from + file);
			console.log(move_in + folder);
			var new_class = $('.selected').parent('li').attr('class');
			var new_dir = move_in + folder + "/";
			var bool = $('.selected').parent('li').hasClass('dir');
			if (bool == true) {
				var ul_to_append = $('.selected').parent("li").children('ul').html();
				ul_to_append = ul_to_append.replace(/move_from/g, move_in + folder + "/");
				var uniqid = new Date().getUTCMilliseconds();
				$(this).parent().children('ul').append("<li class='" + new_class + "' rel='" + new_dir + "'><div class='filename'>" + ui.draggable.text() + "</div><div class='opendir " + uniqid + "'></div><ul style='display:block;'>" + ul_to_append + "</ul></li>");
				$('.' + uniqid).parent().find('.opendir').each(function() {
					$(this).attr('class', 'opendir ' + uniqid);
				});

			} else {
				$(this).parent().children('ul').append("<li class='" + new_class + "' rel='" + new_dir + "'><div class='filename'>" + ui.draggable.text() + "</div></li>");
			}
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

			$(".filename").click(function() {
				dragTree(this);
			});
		}
	});

	var selected_folder = $('.selected').parent().attr('rel');
	var selected_file = $(selector).html();
	console.log(selected_folder + selected_file);
	// FINE
}


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

});
