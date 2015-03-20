<?php
    // Sets the proper content type for javascript
    header("Content-type: application/javascript");
    include_once('../includes/config.php');
?>

function Wall (addForm, editForm, contentDiv) {
	var addForm = $(addForm);
	var editForm = $(editForm);
	var contentDiv = $(contentDiv);
	var btnImg = contentDiv.find('.btn-img');
	var inputImg = btnImg.closest('div').find('input');
	var scope = this;
	var userData = new UserData('#prev-wall');
	userData.table = "walls";
	
	this.changeImg = function(){
		btnImg.on('click', function () {
	            
	        $('#imgModal').modal();

	        $('#imgModal').on('shown.bs.modal', function(){
	            $('#imgModal .modal-content').load('test.php', "", function(){
	            	$(this).find('img').on('click', function () {
	            		var image = 'http://' + location.hostname + '/blog/' + $(this).attr('src');
	            		
	            		inputImg.val(image);
	            		btnImg.html('<img width="auto" src="'+image+'"></img>');
	            		btnImg.removeClass('btn-block');
	   					scope.clearImg();
	            	})
	            	
	            });
	        });
	        $('#imgModal').on('hidden.bs.modal', function(){
	            $('#imgModal .modal-content').html('');
	        });		
		})			
	}
	this.clearImg = function () {
	    var btnClear = $("<div><button type='button' class='btn btn-warning btn-clear-img'>Clear img</button></div>");

	    if(btnImg.find('img').length){
			if(!$('.btn-clear-img').length){
				btnClear.insertAfter(btnImg.parent());
				$('.btn-clear-img').on('click', function () {
					btnImg.html('Image');
					inputImg.val('');
					btnImg.addClass('btn-block');
					$('.btn-clear-img').remove();
				});
			}
	    	
	    }		
	}
	this.onInsert = function (id) {
		userData.getById({id: id}, function(data){
			var data = JSON.parse(data);
			
			if(Object.keys(data).length > 0){
				scope.setForm(data);
			}
		});
	}
	
	this.postForm = function () {
		contentDiv.find('form').on('submit', function () {
			var data = $(this).serializeObject();
			var formName = $(this).attr('name');

			if(formName === 'addWall'){
				userData.insertObject(data, function(data){
			        var data = JSON.parse(data);
			        
			        if(data.status === 'success'){
			            scope.onInsert(data.id);
			            showMsg(".msg-container", "Wall successfully created!" , data.status);	
			        }
			        else
			            showMsg(".msg-container", data.error, "error");		
				});
			}
			if(formName === 'editWall'){
				userData.update(data, function (data) {
					var data = JSON.parse(data);
					
					if(data.status === 'success'){
						showMsg(".msg-container", "Wall successfully updated!" , data.status);
					}
				})
			}

		});		
	}
	this.setForm = function (data) {
		$(addForm).remove();
		
		var formDiv = editForm.parent();
		var formInputs = editForm.find('input');
		var formTextArea = editForm.find('textarea');
		var textAreaName = formTextArea.attr('name');
		var formBtn = editForm.find('.btn-img');
		var formBtnName = formBtn.attr('name');
		
		formDiv.removeClass('hidden');

		formInputs.each(function(){
			var input = $(this);
			var inputName = $(this).attr('name');
			$.map(data, function(v,k){
				if(inputName == k) input.val(v);
				if(textAreaName == k && v != "") formTextArea.val(v);
				if(formBtnName == k && v != ""){
					formBtn.html("<img width='auto' src="+v+"></img>");
					formBtn.removeClass('btn-block')
					scope.clearImg();
				} 

			});

		});
	}
	this.checkContent = function () {
		userData.getByUserId(<?php echo $_SESSION['user']->get_id()?>, {}, function(data){

			var data = JSON.parse(data);
			if(typeof data[0] != "undefined" && Object.keys(data[0]).length > 0){
				scope.setForm(data[0]);
			}
			else{
				return;
			}
		});
	}
	this.checkContent();
	this.postForm();
	this.changeImg();
}