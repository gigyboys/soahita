var zIndex = 5000;

function popup(content, width, closable = true, background = 'rgba(0,0,0,0.5)'){
	console.log("create popup");
	zIndex = zIndex + 2;
	var popup_content = $('<div>', {
		'class':'popup_content',
	}); 
	popup_content.css('z-index', zIndex);
	popup_content.css('background', background);
	if(closable){
		popup_content.addClass( "popup_content_closable" );
	}
	var popupwindow = $('<div>', {
		'class':'popup',
	}); 
	popupwindow.width(width);
	popupwindow.append(content);
	popup_content.append(popupwindow);
	$('body').prepend(popup_content);
	
	centerBloc(popup_content, popupwindow);
}

$(function() {
	$('body').on('click','.otherpopup',function(event){
		var content = '<div style="padding:5px; width:auto; background:#fff""><div style="text-align:center"> other popup apert<br /> ok...</div><div style="text-align:center">	<span class="button_closable" style="background:#888; border-radius: 3px; cursor:pointer; display:inline-block; margin:auto; padding:5px;">	Confirmer	</span></div></div>';
        popup(content, 300, false);
    });
    
    $('#popupme').click(function() {
		var content = '<div style="padding:5px; width:auto; background:#fff"><div style="text-align:center">	<span class="otherpopup" style="cursor:pointer">Que tous sois un ...</span></div><div style="text-align:center">	<span class="button_closable" style="background:#888; border-radius: 3px; cursor:pointer; display:inline-block; margin:auto; padding:5px;">	Confirmer	</span></div></div>';
        var bg = 'rgba(0,0,0,0.8)';
		popup(content, 500, true, bg);
    });
    
	$('body').on('click','.popup_content_closable',function(event){
        $(this).remove();
    });
    
	$('body').on('click','.button_closable',function(event){
		console.log('trigger');
		$(this).closest('.popup_content').remove();
    });
    
	$('body').on('click','.popup',function(event){
        event.stopPropagation();
    });
	
	$(window).resize(function() {
		centerBloc($('.popup_content'), $('.popup'));
    });
    
});

function centerBloc(popup_content, popup){
	var popup_content_height = popup_content.height();
	var popup_height = popup.height();
	popup.css('margin-top', (popup_content_height-popup_height)/2);
}