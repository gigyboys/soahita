
$(function() {	
	//suppression product
	$('body').on('click','.btn_delete_popup',function(e){
		var id = $(this).data("id");
		var label = $(this).data("label");
		var target = $(this).data("target");
		
		var content = "";
		content += '<div style="padding:10px; width:auto; background:#fff; border-radius:3px">';
			content += '<div style="text-align:center;padding:10px 0"> '+label+'</div>';
			content += '<div style="text-align:center">	';
				content += '<span class="button_closable" style="background:#bbb; border-radius: 3px; cursor:pointer; display:inline-block; margin:auto; padding:5px;margin:5px">	Annuler	</span>';
				content += '<a class="confirm_delete" data-id="'+id+'" href="'+target+'" style="background:#bbb; border-radius: 3px; cursor:pointer; display:inline-block; margin:auto; padding:5px;margin:5px">	Confirmer	</a>	';
			content += '</div>';
		content += '</div>';
        
		popup(content, 500, true);
		
    });
    
});