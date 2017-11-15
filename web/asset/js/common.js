function resetBlocEdit(bloc_editable){
	var bloc_view = bloc_editable.find(".bloc_view");
	var bloc_edit = bloc_editable.find(".bloc_edit");
	var btn_edit = bloc_editable.find(".btn_edit");
	var btn_save = bloc_editable.find(".btn_save");
	var btn_reset = bloc_editable.find(".btn_reset");
	var btn_loading = bloc_editable.find(".btn_loading");
	bloc_view.show();
	bloc_edit.hide();
	btn_edit.show();
	btn_save.hide();
	btn_reset.hide();
	btn_loading.hide();
}

function editBlocEdit(bloc_editable){
	var bloc_view = bloc_editable.find(".bloc_view");
	var bloc_edit = bloc_editable.find(".bloc_edit");
	var btn_edit = bloc_editable.find(".btn_edit");
	var btn_save = bloc_editable.find(".btn_save");
	var btn_reset = bloc_editable.find(".btn_reset");
	var btn_loading = bloc_editable.find(".btn_loading");
	bloc_view.hide();
	bloc_edit.show();
	btn_edit.hide();
	btn_save.show();
	btn_reset.show();
	btn_loading.hide();
}

function loadBlocEdit(bloc_editable){
	var bloc_view = bloc_editable.find(".bloc_view");
	var bloc_edit = bloc_editable.find(".bloc_edit");
	var btn_edit = bloc_editable.find(".btn_edit");
	var btn_save = bloc_editable.find(".btn_save");
	var btn_reset = bloc_editable.find(".btn_reset");
	var btn_loading = bloc_editable.find(".btn_loading");
	bloc_view.hide();
	bloc_edit.show();
	btn_edit.hide();
	btn_save.hide();
	btn_reset.hide();
	btn_loading.show();
}

$(function() {
	$('body').on('click','.btn_edit',function(event){
        var $this = $(this);
        var bloc_editable = $this.closest(".bloc_editable");
		editBlocEdit(bloc_editable);
    });
    
	$('body').on('click','.btn_reset',function(event){
        var $this = $(this);
        var bloc_editable = $this.closest(".bloc_editable");
		resetBlocEdit(bloc_editable);
    });
});

$(function() {
    $(window).resize(function() {
        initSpinner();
    });
});

function createSpinner() {
	var spinner = "<div id='spinnerloading'><div><span>Chargement...</span></div></div>";
	$( "body" ).prepend( spinner );
	initSpinner();
}

function initSpinner() {
	$("#spinnerloading").css('width',$(window).width());
	$("#spinnerloading").css('height',$(window).height());
	$("#spinnerloading div").css('margin-top',($(window).height() - $("#spinnerloading div").height())/2);
}

function destroySpinner() {
	$( "#spinnerloading" ).remove();
}


$(function() {	
	
	//get popup for changing image
	$('body').on('click','#change_image, .change_image_sidebar',function(event){
		var target = $(this).data("target");
		
		var content = "<div style='text-align:center;padding:10px; color:#fff'>Chargement ...</div>";
		popup(content, 560, true);
		
		$.ajax({
			type: 'POST',
			url: target,
			dataType : 'json',
			success: function(data){
				if(data.state){
					content = data.content;
					$(".popup").html(content);
					centerBloc($('.popup_content'), $('.popup'));
				}else{
					
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
			}
		});
		
    });
	
	
    /*
    * upload image
    */
	$('body').on('change','#imagefile',function(event){
        var $this = $(this);
        var file = $this[0].files[0];
        var target = $this.data('target');
        var type = $this.data('type');
        var data = new FormData();
		
		if(type == "product"){
			data.append('productimage[file]', file);
			var imageid = "#product_image";
		}else if(type == "person"){
			data.append('personimage[file]', file);
			var imageid = "#person_image";
		}
		
		createSpinner();
        $.ajax({
            type: 'POST',
            url: target,
            data: data,
            contentType: false,
            processData: false,
            dataType : 'json',
            success: function(data){
				if(data.state){
					$(".image_item").removeClass("active");
					$("#images_wrapper").append(data.imageItemContent);
					$(imageid).attr("src", data.image120x120);
					$("#images_wrapper").animate({ scrollTop: $('#images_wrapper').prop("scrollHeight")}, 500);
					
					if(type == "person"){
						if(data.isUserOnline){
							$('.image_person_online').attr("src", data.image120x120);
						}
					}
				}else{
					alert("Une erreur est survenue");
				}
				destroySpinner();
            },
            error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR.status);
				console.log(textStatus);
				console.log(errorThrown);
				destroySpinner();
			}
        });
    });
	
	//delete image
	$('body').on('click','.delete_image',function(event){
		var $this = $(this)
		var target = $this.data("target");
		var type = $this.data("type");
		
		if(type == "product"){
			var imageid = "#product_image";
		}else if(type == "person"){
			var imageid = "#person_image";
		}
		
		createSpinner();
		$.ajax({
			type: 'POST',
			url: target,
			dataType : 'json',
			success: function(data){
				if(data.state){
					$this.closest(".image_item").remove();
					if(data.isCurrent){
						$("#default_image").addClass("active");
						$(imageid).attr("src", data.image120x120);
						$("#images_wrapper").animate({ scrollTop: 0}, 500);
					}
					
					if(type == "person"){
						if(data.isUserOnline){
							$('.image_person_online').attr("src", data.image120x120);
						}
					}
					destroySpinner();
				}else{
					alert("Une erreur est survenue");
					destroySpinner();
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				destroySpinner();
			}
		});
		
    });
	
    /*
    * select image
    */
    $('body').on('click','.image_popup',function(event){
        var $this = $(this);
        var target = $this.data('target');
        var type = $this.data('type');
		
		if(type == "product"){
			var imageid = "#product_image";
		}else if(type == "person"){
			var imageid = "#person_image";
		}
		
		createSpinner();
        $.ajax({
            type: 'POST',
            url: target,
            dataType : 'json',
            success: function(data){
				$(".image_item").removeClass("active");
				$this.closest(".image_item").addClass("active");
				$(imageid).attr("src", data.image120x120);
					
				if(type == "person"){
					if(data.isUserOnline){
						$('.image_person_online').attr("src", data.image120x120);
					}
				}
				
				destroySpinner();
            },
            error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR.status);
				console.log(textStatus);
				console.log(errorThrown);
				destroySpinner();
			}
        });
    });
	
    /*
    * sidebar-toogle
    */
    $('body').on('click','.sidebar-toggle',function(event){
        var $this = $(this);
		var target = $this.data('target');
		if($('body').hasClass('sidebar-collapse')){
			console.log(true);
			target += "?collapse=false";
		}else{$
			console.log(false);
			target += "?collapse=true";
		}
		
        $.ajax({
            type: 'POST',
            url: target,
            dataType : 'json',
            success: function(data){
				console.log(data.collapse);
            },
            error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR.status);
				console.log(textStatus);
				console.log(errorThrown);
			}
        });
		
    });
    
});
