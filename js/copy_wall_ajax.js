<?php
    // Sets the proper content type for javascript
    header("Content-type: application/javascript");
    include_once('../includes/config.php');
?>
function imgBtn() {
	$('#edit-wall .btn-img').on('click', function () {
        var btnImg = $(this);
        var inputImg = $('#edit-wall form input[name="image"]');
        $('#imgModal').modal();

        $('#imgModal').on('shown.bs.modal', function(){
            $('#imgModal .modal-content').load('test.php', "", function(){
            	$(this).find('img').on('click', function () {
            		var img = $(this).attr('src');
            		inputImg.attr('value', img);
            		btnImg.html('<img width="auto" src="'+img+'"></img>');
            		btnImg.removeClass('btn-block');
   					clearBtn();
            	})
            	
            });
        });
        $('#imgModal').on('hidden.bs.modal', function(){
            $('#imgModal .modal-content').html('');
        });		
	})	
}
function setContent(){

	$('#edit-wall form').on('submit', function () {
		var data = $(this).serializeObject();
		var form = $(this);
		var formName = $(this).attr('name');
		if(formName === 'addWall'){
			userData.insertObject(data, function(data){
		        var data = JSON.parse(data);
		        if(data.status === 'success'){
		            onInsert(data.id);
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
function onInsert (id) {
	userData.getById({id: id}, function(data){
		var data = JSON.parse(data);
		if(Object.keys(data).length > 0){
			setForm('#edit-wall form[name="editWall"]', data);
		}




	});
}
function setForm(formName, data){
	
	$('#edit-wall form[name="addWall"]').remove();

	var form = $(formName);
	var formDiv = $(formName).parent();
	var formInputs = $(formName + ' input');
	var formTextArea = $(formName + ' textarea');
	var textAreaName = formTextArea.attr('name');
	var formBtn = $(formName + ' .btn-img');
	var formBtnName = formBtn.attr('name');
	
	formDiv.removeClass('hidden');

	formInputs.each(function(){
		var input = $(this);
		var inputName = $(this).attr('name');
		$.map(data, function(v,k){
			if(inputName == k) input.val(v);
			if(textAreaName == k && v.length > 0) formTextArea.val(v);
			if(formBtnName == k && v.length > 0){
				formBtn.html("<img width='auto' src="+v+"></img>");
				clearBtn();
			} 

		});

	});
}
function clearBtn () {

    var btnClear = $("<div><button type='button' class='btn btn-warning btn-clear-img'>Clear img</button></div>");
    var btnImg = ($('#edit-wall form[name="addWall"] .btn-img').length > 0) ? $('#edit-wall form[name="addWall"] .btn-img') : $('#edit-wall form[name="editWall"] .btn-img');
    var inputImg = $('#edit-wall form input[name="image"]');

    $('.btn-clear-img').remove();
    
    if(btnImg.find('img').length){
    	btnImg.removeClass('btn-block');
		if(!$('.btn-clear-img').length){
			btnClear.insertAfter(btnImg.parent());
			btnClear.on('click', function () {
				btnImg.html('Image');
				inputImg.val('');
				btnImg.addClass('btn-block');
				$('.btn-clear-img').remove();
			});
		}
    	
    }
}
$(function () {
	userData = new UserData('#prev-wall');
	userData.table = 'walls';
	console.log('sadsad');
	userData.getByUserId(<?php echo $_SESSION['user']->get_id()?>, {}, function(data){

		var data = JSON.parse(data);
		if(typeof data[0] != "undefined" && Object.keys(data[0]).length > 0){
			setForm('#edit-wall form[name="editWall"]', data[0]);
		}
	})

	imgBtn();
	setContent();
})